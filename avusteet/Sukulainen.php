<?php
require_once('Kysely.php');

class Sukulainen extends Kysely {
    public function vapaatTyot($kayttaja)    {
        // Tämä kysely hakee sukulainen.php sivun vapaana olevat työt -listan tiedot.     
        $vapaat_tyot = $this->valmistele("SELECT mummo.nimi as pomo, tyot.id, tyot.nimi, tyot.kuvaus,
            tyot.deadline FROM tyot, (SELECT kayttajat.id, kayttajat.nimi FROM kayttajat, sukulaisuus 
            WHERE sukulaisuus.sukulainen_id = ? AND kayttajat.id = sukulaisuus.mummo_id
            AND kayttajat.poistettu = false) AS mummo WHERE tyot.milloin_tehdaan IS NULL
            AND tyot.mummo_id = mummo.id ORDER BY deadline");
        
        $vapaat_tyot->execute(array($kayttaja->id));
        return $vapaat_tyot->fetchAll();
    }
    
    public function lisaaTyoVaraus($paivays, $tyoId, $kayttaja)  {
        $lisaaVaraus = $this->valmistele("INSERT INTO tyontekijat 
            (nimi_id, tyonnimi_id, onko_tyo_tehty) VALUES 
            (?, ?, false)");
        $lisaaVaraus->execute(array($kayttaja->id, $tyoId, ));	
        
        $lisaaPaivays = $this->valmistele("UPDATE tyot 
            SET milloin_tehdaan = ? WHERE id = ?");
        $lisaaPaivays->execute(array($paivays, $tyoId));
        return array($lisaaVaraus, $lisaaPaivays);
    }
    
    public function haeOmatTyovaraukset($kayttaja)   {
        // Tämä kysely hakee sukulainen.php sivun omat varaukset -listan tiedot.     
        $omat_varaukset = $this->valmistele("SELECT mummo.pomoid, mummo.pomo, tyot.id as tyoid, tyontekijat.id as id, tyot.nimi, 
            tyot.kuvaus, tyot.deadline, tyot.milloin_tehdaan as milloin FROM 
            tyot, tyontekijat, (SELECT kayttajat.id AS pomoid, kayttajat.nimi AS pomo FROM kayttajat, sukulaisuus 
            WHERE kayttajat.poistettu = false AND sukulaisuus.sukulainen_id = ? AND
            sukulaisuus.mummo_id = kayttajat.id) AS mummo WHERE tyot.poistettu=false AND 
            tyot.id=tyontekijat.tyonnimi_id AND tyontekijat.onko_tyo_tehty=false 
            AND tyontekijat.nimi_id = ? AND mummo.pomoid = tyot.mummo_id ORDER BY deadline;");
        $omat_varaukset->execute(array($kayttaja->id, $kayttaja->id));
        return $omat_varaukset->fetchAll();
    }

        public function poistaTyoVaraus($id, $tyoid) {
        $poistaVaraus = $this->valmistele("DELETE FROM tyontekijat WHERE id = ?");
        $poistaVaraus->execute(array($id));
        
        $poistaVarausPaiva = $this->valmistele("UPDATE tyot SET milloin_tehdaan = NULL
            WHERE id = ? AND ? NOT IN (SELECT tyonnimi_id FROM tyontekijat)");
        $poistaVarausPaiva->execute(array($tyoid, $tyoid));
        
        return array($poistaVaraus, $poistaVarausPaivas);
    }
    
    public function haeOmatSukulaiset($kayttaja)    {
        //Tämä kysely hakee sukulaiset.php sivulle kirjautuneen sukulaisen muun sukulaiset.
        $sukulaisen_sukulaislista_kysely = $this->valmistele("SELECT kayttajat.id, kayttajat.nimi FROM kayttajat, 
            (SELECT sukulaisuus.sukulainen_id as suku_id FROM sukulaisuus WHERE sukulaisuus.mummo_id IN 
            (SELECT sukulaisuus.mummo_id FROM sukulaisuus WHERE sukulaisuus.sukulainen_id = ?)) as suku WHERE
            kayttajat.poistettu = false AND kayttajat.id = suku.suku_id AND kayttajat.id != ? ORDER BY kayttajat.nimi");

        $sukulaisen_sukulaislista_kysely->execute(array($kayttaja->id, $kayttaja->id));
        return $sukulaisen_sukulaislista_kysely->fetchAll();
    }
    
    public function luoTalkoot($tyoId, $sukulainen, $kayttaja)    {
        //Tämä päivitys liittää samalle työlle useamman tekijän.
        $talkoot = $this->valmistele("INSERT INTO tyontekijat 
            (nimi_id, tyonnimi_id) VALUES (?, ?)");
        
        return $this->onkoSukulainen($tyoId, $sukulainen) && $talkoot->execute(array($sukulainen, $tyoId));
    }
    
    public function onkoSukulainen($tyoId, $sukulainen)    {
        $onkosukua = $this->valmistele("SELECT id FROM sukulaisuus JOIN
            (SELECT mummo_id FROM tyot WHERE id = ?) AS mummo
            USING (mummo_id) WHERE sukulainen_id = ?");
        return $onkosukua->execute(array($tyoId, $sukulainen)) && $onkosukua->rowCount() > 0;
    }
}

$sukuKyselija = new Sukulainen($yhteys);

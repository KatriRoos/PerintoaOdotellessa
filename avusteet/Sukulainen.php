<?php
require_once('Kysely.php');

class Sukulainen extends Kysely {
    public function vapaatTyot($kayttaja)    {
        // Tämä kysely hakee sukulainen.php sivun vapaana olevat työt -listan tiedot.     
        $vapaat_tyot = $this->valmistele("SELECT mummo.nimi as pomo, tyot.id, tyot.nimi, tyot.kuvaus,
            tyot.deadline FROM tyot, (SELECT kayttajat.id, kayttajat.nimi FROM kayttajat, sukulaisuus 
            WHERE sukulaisuus.sukulainen_id = ? AND kayttajat.id = sukulaisuus.mummo_id
            AND kayttajat.poistettu = false) AS mummo
            WHERE tyot.milloin_tehdaan IS NULL
            AND tyot.mummo_id = mummo.id AND tyot.poistettu = false 
            AND tyot.id NOT IN (SELECT tyonnimi_id AS id FROM tyontekijat 
            WHERE tyontekijat.onko_tyo_tehty = true)
            ORDER BY deadline");
        
        $vapaat_tyot->execute(array($kayttaja->id));
        return $vapaat_tyot->fetchAll();
    }
    
    public function lisaaTyoVaraus($paivays, $tyoId, $kayttaja)  {
        //Sukulainen varaa itselleen työn
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
            sukulaisuus.mummo_id = kayttajat.id) AS mummo
            WHERE tyot.poistettu=false AND tyot.id=tyontekijat.tyonnimi_id AND 
            tyontekijat.tyonnimi_id NOT IN
            (SELECT tyonnimi_id FROM tyontekijat WHERE onko_tyo_tehty = true)
            AND tyontekijat.nimi_id = ? AND mummo.pomoid = tyot.mummo_id ORDER BY deadline;");
        $omat_varaukset->execute(array($kayttaja->id, $kayttaja->id));
        return $omat_varaukset->fetchAll();
    }

    public function poistaTyoVaraus($id, $tyoid) {
        //Poistaa sukulaisen työvarauksen.
        $poistaVaraus = $this->valmistele("DELETE FROM tyontekijat WHERE id = ?");
        $poistaVaraus->execute(array($id));
        
        $poistaVarausPaiva = $this->valmistele("UPDATE tyot SET milloin_tehdaan = NULL
            WHERE id = ? AND ? NOT IN (SELECT tyonnimi_id FROM tyontekijat)");
        $poistaVarausPaiva->execute(array($tyoid, $tyoid));
        
        return array($poistaVaraus, $poistaVarausPaivas);
    }
    
    public function haeOmatSukulaiset($kayttaja)    {
        //Tämä kysely hakee sukulaiset.php sivulle kirjautuneen sukulaisen muun sukulaiset.
        $sukulaisen_sukulaislista_kysely = $this->valmistele("SELECT DISTINCT kayttajat.id, kayttajat.nimi FROM kayttajat, 
            (SELECT sukulaisuus.sukulainen_id as suku_id FROM sukulaisuus WHERE sukulaisuus.mummo_id IN 
            (SELECT sukulaisuus.mummo_id FROM sukulaisuus WHERE sukulaisuus.sukulainen_id = ?)) as suku WHERE
            kayttajat.poistettu = false AND kayttajat.id = suku.suku_id AND kayttajat.id != ? ORDER BY kayttajat.nimi");

        $sukulaisen_sukulaislista_kysely->execute(array($kayttaja->id, $kayttaja->id));
        return $sukulaisen_sukulaislista_kysely->fetchAll();
    }
    
    public function luoTalkoot($tyoId, $sukulainen)    {
        //Laitetaan samalle työlle useamman tekijän.
        $talkoot = $this->valmistele("INSERT INTO tyontekijat 
            (nimi_id, tyonnimi_id) VALUES (?, ?)");
        
        return $this->onkoSukulainen($tyoId, $sukulainen) &&
                $this->onkoSukulainenJoTalkoissa($tyoId, $sukulainen) &&
                $talkoot->execute(array($sukulainen, $tyoId));
    }
    
    public function onkoTyoTalkoo($tyoid)   {
        //Kysellään onko tietty työ talkoo eli useampi varannut.
        $onko = $this->valmistele("SELECT * FROM tyontekijat WHERE 
            tyonnimi_id = ? AND onko_tyo_tehty = false");
        return $onko->execute(array($tyoid)) && $onko->rowCount() > 1;
    }


    public function onkoSukulainenJoTalkoissa($tyoId, $sukulainen) {
        //Etsii onko sukulainen jo ilmoitettu talkoisiin.
        $onkoTalkoissa = $this->valmistele("SELECT * FROM tyontekijat WHERE 
            nimi_id = ? AND tyonnimi_id = ?");
        return $onkoTalkoissa->execute(array($sukulainen, $tyoId));
    }


    public function onkoSukulainen($tyoId, $sukulainen)    {
        //Etsii sukulaisen omat sukulaiset.
        $onkosukua = $this->valmistele("SELECT id FROM sukulaisuus JOIN
            (SELECT mummo_id FROM tyot WHERE id = ?) AS mummo
            USING (mummo_id) WHERE sukulainen_id = ?");
        return $onkosukua->execute(array($tyoId, $sukulainen)) && $onkosukua->rowCount() > 0;
    }
    
    public function onkoTalkoolaisia()  {
        //Etsii onko työllä useampi varaus.
        $onkoTalkoolaisia = $this->valmistele("SELECT * FROM (SELECT tyonnimi_id AS id, 
            COUNT(tyonnimi_id) AS maara FROM tyontekijat WHERE tyontekijat.onko_tyo_tehty = false
            AND tyonnimi_id NOT IN (SELECT tyonnimi_id FROM tyontekijat WHERE onko_tyo_tehty = true)
            GROUP BY tyonnimi_id) AS kysely
            WHERE kysely.maara > 1");
        $onkoTalkoolaisia->execute();
        return $onkoTalkoolaisia->fetchAll();
    }
    
    public function haeTalkoolaiset($tyoid)   {
        //Hakee tietyn talkoon työläiset.
        $talkoolaiset = $this->valmistele("SELECT kayttajat.nimi FROM kayttajat, tyontekijat WHERE
            tyontekijat.tyonnimi_id = ? AND kayttajat.id = tyontekijat.nimi_id"); 
        $talkoolaiset->execute(array($tyoid));
        return $talkoolaiset->fetchAll();
    }
    
    public function haeTalkooPomo($tyoid)   {
        //Hakee kuka talkoot järjestää.
        $talkoopomo = $this->valmistele("SELECT kayttajat.nimi AS pomo FROM kayttajat, tyot
            WHERE kayttajat.id = tyot.mummo_id AND tyot.id = ?");
        $talkoopomo->execute(array($tyoid));
        return $talkoopomo->fetch();
    }
    
    public function haeTalkooTyo($tyoid)   {
        //Hakee mikä talkootyö on kyseessä ja milloin tehdään.
        $talkooTyo = $this->valmistele("SELECT tyot.nimi AS nimi, 
            tyot.milloin_tehdaan AS milloin FROM tyot
            WHERE tyot.id = ?");
        $talkooTyo->execute(array($tyoid));
        return $talkooTyo->fetch();
    }
    
    public function pisteet($mummoId)  {
        // Tämä kysely hakee piste-listaan nimet ja pisteet.     
        $pisteet = $this->valmistele("SELECT * FROM (SELECT DISTINCT kayttajat.id, kayttajat.nimi
            FROM kayttajat, (SELECT sukulaisuus.sukulainen_id as suku_id FROM sukulaisuus 
            WHERE sukulaisuus.mummo_id = ?) as suku 
            WHERE kayttajat.poistettu = false AND kayttajat.id = suku.suku_id) AS eka
            LEFT JOIN
            (SELECT tyontekijat.nimi_id, COUNT(tyontekijat.id) AS pisteet FROM tyontekijat, tyot WHERE
            tyontekijat.onko_tyo_tehty = true AND tyontekijat.tyonnimi_id = tyot.id 
            AND tyot.mummo_id = ? GROUP BY tyontekijat.nimi_id) AS pisteet
            ON pisteet.nimi_id = eka.id ORDER BY pisteet.pisteet DESC NULLS LAST");

        $pisteet->execute(array($mummoId, $mummoId));
        return $pisteet->fetchAll();
    }
    
    public function mummot($kayttaja)   {
        // Tämä kysely kayttajan omat mummot.     
        $pisteet = $this->valmistele("SELECT kayttajat.id AS mummot, kayttajat.nimi, 
            kayttajat.status FROM kayttajat,sukulaisuus WHERE 
            sukulaisuus.sukulainen_id = ? AND kayttajat.id =
            sukulaisuus.mummo_id AND kayttajat.poistettu = false");

        $pisteet->execute(array($kayttaja->id));
        return $pisteet->fetchAll();
    }
}

$sukuKyselija = new Sukulainen($yhteys);

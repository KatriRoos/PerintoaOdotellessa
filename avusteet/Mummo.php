<?php
require_once('Kysely.php');

class Mummo extends Kysely {
    public function mummonTyolistaKysely($kayttaja)  {
        // Tämä kysely hakee mummo.php sivun työlistaan kaikki työt.     
        $mummon_tyolista_kysely = $this->valmistele("SELECT * from 
            (SELECT tyot.id, tyot.mummo_id as mi, tyot.nimi, tyot.kuvaus, tyot.deadline, 
            tyot.poistettu, varannut.varannut, teki.teki FROM tyot
            
            LEFT JOIN (SELECT tyontekijat.tyonnimi_id, kayttajat.nimi AS varannut 
            FROM kayttajat,tyontekijat WHERE
            kayttajat.id = tyontekijat.nimi_id AND onko_tyo_tehty=false 
            AND kayttajat.poistettu=false) AS varannut 
            ON tyot.id = varannut.tyonnimi_id
            LEFT JOIN (SELECT tyontekijat.tyonnimi_id, kayttajat.nimi AS teki FROM kayttajat,tyontekijat WHERE
            kayttajat.id = tyontekijat.nimi_id AND onko_tyo_tehty=true) AS teki
            ON tyot.id = teki.tyonnimi_id) as taulu
            WHERE taulu.mi = ? AND taulu.poistettu=false
            ORDER BY deadline");

        $mummon_tyolista_kysely->execute(array($kayttaja->id));
        return $mummon_tyolista_kysely->fetchAll();
    }
  
    public function poistaTyo($tyoId) {
        $poistaTyo = $this->valmistele("UPDATE tyot SET poistettu = 'true' WHERE id = ?");   
        return $poistaTyo->execute(array($tyoId));
    }
    
    public function lisaaTyo($kayttaja, $uusi_nimi, $uusi_kuvaus, $uusi_deadline)  {
        $uusi_tyo = $this->valmistele("INSERT INTO tyot 
            (mummo_id, nimi, kuvaus, deadline, poistettu, milloin_tehdaan) VALUES 
            (?, ?, ?, ?, false, NULL)");
        return $uusi_tyo->execute(array($kayttaja->id, $uusi_nimi, $uusi_kuvaus, $uusi_deadline));	
    }
    
    public function mummonSukulaiset($kayttaja)  {
        // Tämä kysely hakee mummo.php sivun sukulaiset-listaan nimet ja pisteet.     
        $mummon_sukulaisetlista_kysely = $this->valmistele("SELECT * FROM sukulaisuus, (SELECT kayttajat.id, kayttajat.nimi, pisteet.pisteet FROM kayttajat
            LEFT JOIN (SELECT kayttajat.nimi AS nimi, COUNT(tyontekijat.nimi_id) as pisteet FROM tyontekijat,
            kayttajat WHERE kayttajat.id=tyontekijat.nimi_id AND onko_tyo_tehty=true AND kayttajat.poistettu = false GROUP BY nimi) AS pisteet 
            ON kayttajat.nimi=pisteet.nimi) AS suku WHERE 
            suku.id=sukulaisuus.sukulainen_id AND sukulaisuus.mummo_id = ? ORDER BY suku.nimi");

        $mummon_sukulaisetlista_kysely->execute(array($kayttaja->id));
        return $mummon_sukulaisetlista_kysely->fetchAll();
    }

    public function lisaaTyolleTekija($tyoid, $tekija) {
        if($this->onkoTyontekija($tyoid, $tekija))  {
            $tyontekija = $this->valmistele("UPDATE tyontekijat SET onko_tyo_tehty = true
                WHERE tyonnimi_id = ? AND nimi_id = ?");   
            $tyontekija->execute(array($tyoid, $tekija));
        }
        else    {
            $uusi_tyontekija = $this->valmistele("INSERT INTO tyontekijat 
                (nimi_id, tyonnimi_id, onko_tyo_tehty) VALUES
                (? ,? ,true)"); 
            $uusi_tyontekija->execute(array($tekija, $tyoid));
        }
    }
    
    public function onkoTyontekija($tyoid, $tekija)    {
        $tyontekija = $this->valmistele("SELECT id FROM tyontekijat
            WHERE tyonnimi_id = ? AND nimi_id = ?");
        return $tyontekija->execute(array($tyoid, $tekija)) && $tyontekija->rowCount() > 0;
    }
}

$mummoKyselija = new Mummo($yhteys);

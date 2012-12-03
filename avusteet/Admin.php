<?php
require_once('Kysely.php');

class Admin extends Kysely {
   
    public function haeSukulaiset($kayttaja) {
        // Tämä kysely hakee admin.php sivun sukulaiset-listaan nimet ja kayttajatunnukset.
        $admin_sukulaisetlista_kysely = $this->valmistele("SELECT id, nimi, 
            kayttajatunnus FROM kayttajat WHERE poistettu = false AND status IS NULL
            AND id != ?");
        $admin_sukulaisetlista_kysely->execute(array($kayttaja->id));
        return $admin_sukulaisetlista_kysely->fetchAll();
    }
    
    public function haeSukulaisetJaKirjautunut() {
        // Tämä kysely hakee admin.php sivun sukulaisuussuhteet sukulaislistaan nimet ja kayttajatunnukset.
        $admin_sukulaisetlista_kysely = $this->valmistele("SELECT id, nimi, 
            kayttajatunnus FROM kayttajat WHERE poistettu = false AND status IS NULL");
        $admin_sukulaisetlista_kysely->execute();
        return $admin_sukulaisetlista_kysely->fetchAll();
    }
    
    public function haeMummot($kayttaja) {
        // Tämä kysely hakee admin.php sivun mummot-listaan nimet ja kayttajatunnukset.     
        $admin_mummotlista_kysely = $this->valmistele("SELECT id, nimi, status, kayttajatunnus 
            FROM kayttajat WHERE poistettu = false AND status IS NOT NULL AND id != ?");
        $admin_mummotlista_kysely->execute(array($kayttaja->id));
        return $admin_mummotlista_kysely->fetchAll();
    }
    
    public function haeMummotJaKirjautunut()    {
        // Tämä kysely hakee admin.php sivun sukulaissuhteet mummotlistaan nimet ja kayttajatunnukset.     
        $admin_mummotlista_kysely = $this->valmistele("SELECT id, nimi, status, kayttajatunnus 
            FROM kayttajat WHERE poistettu = false AND status IS NOT NULL");
        $admin_mummotlista_kysely->execute();
        return $admin_mummotlista_kysely->fetchAll();
    }

        public function poistaKayttaja($sukulainen)  {
        $piilota_sukulainen = $this->valmistele("UPDATE kayttajat SET poistettu = 'true' WHERE id = ?");
        return $piilota_sukulainen->execute(array($sukulainen));
    }
    
    public function lisaaKayttaja($uusi_nimi, $uusi_kayttajatunnus, $uusi_salasana, 
        $uusi_status, $uusi_admin)  {
        $uusi_kayttaja = $this->valmistele("INSERT INTO kayttajat 
            (nimi, kayttajatunnus, salasana, status, admin) VALUES 
            (?, ?, ?, ?, ?)");
        return $uusi_kayttaja->execute(array($uusi_nimi, $uusi_kayttajatunnus, $uusi_salasana, 
        $uusi_status, $uusi_admin));	
    }
    
    public function luoSukulaiset($sukulainen, $mummo) {
        $sukulaisuus = $this->valmistele("INSERT INTO sukulaisuus 
            (sukulainen_id, mummo_id) VALUES (?, ?)");
        return $sukulaisuus->execute(array($sukulainen, $mummo));
    }
    
    public function haeSukulaissuhteet() {
        $sukulaisuus = $this->valmistele("SELECT mummo.nimi as mummeli, sukulainen.nimi, sukulaisuus.id
            FROM sukulaisuus JOIN kayttajat AS mummo
            ON mummo_id = mummo.id AND mummo.poistettu = false
            JOIN kayttajat AS sukulainen
            ON sukulainen_id = sukulainen.id AND sukulainen.poistettu = false
            ORDER BY mummeli, nimi");
        $sukulaisuus->execute();
        return $sukulaisuus->fetchAll();
    }
    
    public function poistaSukulaissuhde($id) {
        $piilota_sukulainen = $this->valmistele("DELETE FROM sukulaisuus WHERE id = ?");
        return $piilota_sukulainen->execute(array($id));
    }
}

$adminKyselija = new Admin($yhteys);


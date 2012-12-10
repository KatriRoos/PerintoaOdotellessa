<?php
require_once('Kysely.php');

class Kyselyt extends Kysely {

  //Tunnistaa käyttäjän.  
  public function tunnista($tunnus, $salasana) {
    $kysely = $this->valmistele('SELECT id FROM kayttajat WHERE kayttajatunnus = ? AND salasana = ?');
    if ($kysely->execute(array($tunnus, $salasana))) {
      return $kysely->fetchColumn();
    } else {
      return null;
    }
  }
  
  //Tarkistaa onko käyttäjä mummo.
  public function onkomummo($kayttaja) {
    $kysely = $this->valmistele('SELECT status FROM kayttajat WHERE id = ?');
	var_dump($kayttaja);
	$kysely->execute(array($kayttaja));
    return $kysely->fetchColumn();
  }
  
  //Tarkistaa onko käyttäjä admin.
  public function onkoadmin($kayttaja) {
    $kysely = $this->valmistele('SELECT admin FROM kayttajat WHERE id = ?');
	var_dump($kayttaja);
	$kysely->execute(array($kayttaja));
    return $kysely->fetchColumn();
  }
  
  //Hakee kirjautuneen käyttäjän tiedot.
  public function haeKayttaja($id) {
    $kysely = $this->valmistele('SELECT id, nimi, kayttajatunnus, status, admin FROM kayttajat WHERE id = ?');
	$kysely->execute(array($id));
    return $kysely->fetchObject();
  }

}

$kyselija = new Kyselyt($yhteys);
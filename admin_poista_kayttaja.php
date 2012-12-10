<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

//Varmistetaan, että käyttäjä admin.
varmistaAdmin($kayttaja);

//"Poistetaan" käyttäjä.
$adminKyselija->poistaKayttaja($_POST['sukulaiset']);

ohjaa('admin.php');


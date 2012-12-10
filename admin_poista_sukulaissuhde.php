<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

//Varmistetaan, että admin.
varmistaAdmin($kayttaja);

//Poistetaan sukulaisuussuhde
$adminKyselija->poistaSukulaissuhde($_POST['suhteet']);

ohjaa('admin.php');
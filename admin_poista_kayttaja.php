<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

varmistaAdmin($kayttaja);

$adminKyselija->poistaKayttaja($_POST['sukulaiset']);

ohjaa('admin.php');


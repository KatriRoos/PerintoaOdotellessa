<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

varmistaAdmin($kayttaja);

$adminKyselija->poistaSukulaissuhde($_POST['suhteet']);

ohjaa('admin.php');
<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

varmistaAdmin($kayttaja);

$adminKyselija->luoSukulaiset($_POST['suku'], $_POST['mummeli']);

ohjaa('admin.php');
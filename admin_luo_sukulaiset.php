<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

//Varmistetaan, että käyttäjä on admin.
varmistaAdmin($kayttaja);

//Uusi sukulaisuussuhde.
$adminKyselija->luoSukulaiset($_POST['suku'], $_POST['mummeli']);

ohjaa('admin.php');
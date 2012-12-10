<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

//Tarkastetaan, että päivämäärä oikein ja lisätään uusi työvaraus.
$pv = (int)substr($_POST['varauspaiva'], 0, 2);
$kk = (int)substr($_POST['varauspaiva'], 3, 2);
$v = (int)substr($_POST['varauspaiva'], 6, 4);


if(checkdate($kk, $pv, $v) && !is_null($_POST['vapaatTyot'])) {
    $sukuKyselija->lisaaTyoVaraus($_POST['varauspaiva'], $_POST['vapaatTyot'], $kayttaja);
}

ohjaa('sukulainen.php');
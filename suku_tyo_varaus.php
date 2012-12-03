<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

$v = (int)substr($_POST['varauspaiva'], 0, 4);
$kk = (int)substr($_POST['varauspaiva'], 5, 2);
$pv = (int)substr($_POST['varauspaiva'], 8, 2);

if(checkdate($kk, $pv, $v) && !is_null($_POST['vapaatTyot'])) {
    $sukuKyselija->lisaaTyoVaraus($_POST['varauspaiva'], $_POST['vapaatTyot'], $kayttaja);
}

ohjaa('sukulainen.php');
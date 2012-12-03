<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

varmistaAdmin($kayttaja);

$uusi_status = empty($_POST['uusi_status']) ? null : $_POST['uusi_status'];

if(!is_null($_POST['uusi_nimi']) && !is_null($_POST['uusi_kayttajatunnus']) &&
        $_POST['uusi_salasana'])    {
    $adminKyselija->lisaaKayttaja($_POST['uusi_nimi'],
    $_POST['uusi_kayttajatunnus'],
    $_POST['uusi_salasana'],
    $uusi_status, $_POST['uusi_admin']);
}

ohjaa('admin.php');
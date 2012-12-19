<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

//Varmistetaan, että admin suorittamassa toimintoa.
varmistaAdmin($kayttaja);

$uusi_status = empty($_POST['uusi_status']) ? null : $_POST['uusi_status'];

//Jos kentissä tekstiä niin lisätään uusi käyttäjä. Salasana muutetaan md5 stringiksi.
if(!is_null($_POST['uusi_nimi']) && !is_null($_POST['uusi_kayttajatunnus']) &&
        $_POST['uusi_salasana'])    {
    $adminKyselija->lisaaKayttaja($_POST['uusi_nimi'],
    $_POST['uusi_kayttajatunnus'],
    md5($_POST['uusi_salasana']),
    $uusi_status, $_POST['uusi_admin']);
}

ohjaa('admin.php');
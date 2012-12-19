<?php

require_once 'avusteet.php';

//Tunnistetaan käyttäjä ja katsotaan onko sukulainen vai mummu ja ohjataan oikealle sivulle.
if (isset($_GET['sisaan'])) {
    $kayttaja_id = $kyselija->tunnista($_POST['tunnus'], md5($_POST['salasana']));
    if (!$kayttaja_id) {
        ohjaa('index.php');
    }
    $mummo = $kyselija->onkomummo($kayttaja_id);
    $sessio->kayttaja_id = $kayttaja_id;
    if ($mummo) {
        ohjaa('mummo.php');
    } else {
        ohjaa('sukulainen.php');
    }
}

//Muita nappulatoimintoja: Admin-sivulle ja uloskirjautuminen.
if (isset($_GET['ulos'])) {
    unset($sessio->kayttaja_id);
    ohjaa('index.php');
} elseif (isset($_GET['admin'])) {
    ohjaa('admin.php');
} elseif (isset($_GET['takaisin'])) {
    $mummo = $kyselija->onkomummo($sessio->kayttaja_id);
    if ($mummo) {
        ohjaa('mummo.php');
    } else {
        ohjaa('sukulainen.php');
    }
} else {
    die('Laiton toiminto!');
}
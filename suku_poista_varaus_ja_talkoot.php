<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

//Haetaan radiobuttonista monta tietoa sisältävä merkkijono ja pilkotaan.
$taulukko = explode(',', $_POST['varatutTyot']);

$id = $taulukko[0];
$tyoId = $taulukko[1];
$mummo_id = $taulukko[2];

//Jos painettu poistoa, poistetaan työvaraus tai
//talkoot-nappi, niin lisätään työlle toinen tekijä.
if(isset($_POST['poistaVaraus']))  {
    $sukuKyselija->poistaTyoVaraus($id, $tyoId);  
}
else if(isset ($_POST['talkoot'])) {
    $sukuKyselija->luoTalkoot($tyoId, $_POST['sukulista']);
}

ohjaa('sukulainen.php');
<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

$taulukko = explode(',', $_POST['varatutTyot']);

$id = $taulukko[0];
$tyoId = $taulukko[1];
$mummo_id = $taulukko[2];

if(isset($_POST['poistaVaraus']))  {
    $sukuKyselija->poistaTyoVaraus($id, $tyoId);  
}
else if(isset ($_POST['talkoot'])) {
    $sukuKyselija->luoTalkoot($tyoId, $_POST['sukulista'], $kayttaja);
}

ohjaa('sukulainen.php');
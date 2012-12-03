<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

varmistaMummo($kayttaja);
if(isset($_POST['poistaTyo']))  {
    $mummoKyselija->poistaTyo($_POST['mummonTyolista']);
}
elseif(isset($_POST['lisaaTyo'])) {
    $v = (int)substr($_POST['uusideadline'], 0, 4);
    $kk = (int)substr($_POST['uusideadline'], 5, 2);
    $pv = (int)substr($_POST['uusideadline'], 8, 2);

    if(checkdate($kk, $pv, $v) && !is_null($_POST['uusityo']) && !is_null($_POST['uusikuvaus'])) {
        $mummoKyselija->lisaaTyo($kayttaja, $_POST['uusityo'], $_POST['uusikuvaus'], $_POST['uusideadline']);
    }
}
elseif(isset($_POST['lisaaTyontekija'])) {
    $mummoKyselija->lisaaTyolleTekija($_POST['mummonTyolista'], $_POST['mummonSukulista']);
}

ohjaa('mummo.php');


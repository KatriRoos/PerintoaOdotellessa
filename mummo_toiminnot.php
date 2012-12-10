<?php
require_once 'avusteet.php';

$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

//Varmistetaan, että käyttäjä on mummo.
varmistaMummo($kayttaja);

//Jos on painettu poisto-nappia, haetaan tiedot työnpoistamista varten, jos
//ollaan painettu lisää työ-nappia, lisätään uusi työ ja jos
//lisää työntekijä -nappia, lisätään työlle tekijä.
if(isset($_POST['poistaTyo']))  {
    $mummoKyselija->poistaTyo($_POST['mummonTyolista']);
}
elseif(isset($_POST['lisaaTyo'])) {
    //Tarkastetaan, että päivämäärä on oikein.
    $pv = (int)substr($_POST['uusideadline'], 0, 2);
    $kk = (int)substr($_POST['uusideadline'], 3, 2);
    $v = (int)substr($_POST['uusideadline'], 6, 4);

    if(checkdate($kk, $pv, $v) && !is_null($_POST['uusityo']) && !is_null($_POST['uusikuvaus'])) {
        $mummoKyselija->lisaaTyo($kayttaja, $_POST['uusityo'], $_POST['uusikuvaus'], $_POST['uusideadline']);
    }
}
elseif(isset($_POST['lisaaTyontekija'])) {
    $mummoKyselija->lisaaTyolleTekija($_POST['mummonTyolista'], $_POST['mummonSukulista']);
}

ohjaa('mummo.php');


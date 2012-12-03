<?php require_once 'avusteet.php';
$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

$mummon_sukulaiset = $mummoKyselija->mummonSukulaiset($kayttaja);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="tyylit/tyylit.css" rel="stylesheet" type="text/css" />
<title>Perintöä odotellessa</title>
</head>

<body>
<div class="helahoito">

<img class="kelluuvasemmalle" alt="Perintöä odotellessa" src="kuvat/etusivun_otsikko.png" height="167" width="994" />


<!--PISTE TAULUKKO JOULUKUULLE-->
<table class="isopunainen" border="1">
    <caption class="tekstityyli_etusivu">
        Perintöpisteytys
    </caption>
    <tr class="taulukon_otsikoidentausta">
        <th scope="col">Nimi</th>
        <th scope="col">Pisteet</th>
    </tr>
    <?php foreach ($mummon_sukulaiset as $mummin_suku){?>
    <tr>
    <td><?php echo $mummin_suku["nimi"]?></td>
    <td><?php echo $mummin_suku["pisteet"]?></td>
    </tr>
    <?php } ?>
</table>

RIKAS UKON KUVA PISTETAULUN VIEREEN JOULUNA
<img class="kelluuvasemmalle" alt="Rikas ukko" src="kuvat/rikas.png" width="160" height="172"/>

</div>
</body>
</html>

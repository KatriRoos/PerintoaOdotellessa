<?php require_once 'avusteet.php';
//Haetaan käyttäjä
$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

//Sivulle pääsee vain jos on joulukuu.
varmistaJoulukuu();

//Haetaan kayttajan mummolista.
$omatMummot = $sukuKyselija->mummot($kayttaja);
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
    
<!--Otsikko-->
<img class="kelluuvasemmalle" alt="Perintöä odotellessa" src="kuvat/etusivun_otsikko.png" height="167" width="994" />

<!--Kuva-->
<img class="pisteukko" alt="Rikas ukko" src="kuvat/rikas.png" width="160" height="172"/>

<!--Pistetaulukko-->
<?php 
foreach ($omatMummot as $mummit)    {
    $sukulaistenPisteet = $sukuKyselija->pisteet($mummit["mummot"]);
?>
<table class="pisteet" border="1">
    <caption class="isopunanen">
        Perintöpisteytys: <?php echo $mummit["nimi"]; ?>-<?php echo $mummit["status"];?>
    </caption>
    <tr class="taulukon_otsikoidentausta">
        <th scope="col">Nimi</th>
        <th scope="col">Pisteet</th>
    </tr>
    <?php foreach ($sukulaistenPisteet as $suku){?>
    <tr>
    <td><?php echo $suku["nimi"]?></td>
    <td><?php echo $suku["pisteet"]?></td>
    </tr>
    <?php } ?>
</table>

<?php } ?>

<!--Nappi josta pääsee takaisin sukulaisen näkymään.-->
<form action="kirjaudu.php?takaisin" method="POST">
    <input name="takaisin" type="submit" class="piste_nappula" id="nappula_takaisin" value="Takaisin" />
</form>
    
<!--Kirjaudu ulos.-->
<form action="kirjaudu.php?ulos" method="POST">
    <input name="kirjaudu_ulos" type="submit" class="piste_nappula" id="nappula_ulos" value="Kirjaudu ulos" />      
</form>   


</div>
</body>
</html>

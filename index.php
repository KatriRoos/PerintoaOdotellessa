<?php require_once 'avusteet.php';
$onkoTalkoita = $sukuKyselija->onkoTalkoolaisia();
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

<img class="ukonkuva" alt="Etusivun kuva sedästä" src="kuvat/etusivun_seta.png" width="500" height="338"/>

<!--Kirjautumislaatikot-->
<div class="lootat">
	<p class="tekstityyli_etusivu">Kirjaudu sisään!<br /><br /></p>
	<p class="tekstityyli_etusivu">Kayttajatunnus</p>
    
    	<form action="kirjaudu.php?sisaan" method="POST">
		<input name="tunnus" type="text" class="kayttajatunnus" maxlength="20"  />
		<p class="tekstityyli_etusivu">Salasana</p>
		<input name="salasana" type="password" class="salasana" maxlength="20" />
    	<input name="kirjaudu" type="submit" class="nappula" value="Kirjaudu" />
        </form>
</div>

<!--Talkoo laatikot jos sellaisia on-->
<?php 
if($onkoTalkoita)   {
    foreach ($onkoTalkoita as $ot)  {
        $pomo = $sukuKyselija->haeTalkooPomo($ot["id"]);
        $tyo = $sukuKyselija->haeTalkooTyo($ot["id"]);
?>

    <div class="tekstityyli_etusivu" id="talkooloota">
        <div class="isopunanen">TALKOOT!</div>
        <div>
            <?php  echo $pomo["pomo"] ?> 
            on järjestänyt talkoot: <?php echo $tyo["nimi"] ?> 
            <?php echo $tyo["milloin"] ?>! 
            Ilmoittautuneet: <?php foreach ($sukuKyselija->haeTalkoolaiset($ot["id"]) as $t)  { 
                                echo $t["nimi"]?>,
                             <?php } ?> 
          
        </div>
        <div class="isopunanen">ILMOITTAUDU JA TIENAA PISTE!</div>
    </div>
<?php } 
}?>

</div>
<!--helahoito päättyy-->
</div>
</body>
</html>

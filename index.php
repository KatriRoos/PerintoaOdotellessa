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

<!--PISTE TAULUKKO JOULUKUULLE
<table class="pisteet">
  <tr>
    <th class="isopunanen" colspan="2" scope="col">Perintö pisteytys</th>
  </tr>
  <tr>
    <td>XXXXXXXXX</td>
    <td>xxxxx p</td>
  </tr>
  <tr>
    <td>XXXXXXXXX</td>
    <td>xxxxx p</td>
  </tr>
  <tr>
    <td>XXXXXXXXX</td>
    <td>xxxxx p</td>
  </tr>
  <tr>
    <td>XXXXXXXXX</td>
    <td>xxxxx p</td>
  </tr>
  <tr>
    <td>XXXXXXXXX</td>
    <td>xxxxx p</td>
  </tr>
</table>

RIKAS UKON KUVA PISTETAULUN VIEREEN JOULUNA
<img class="kelluuvasemmalle" alt="Rikas ukko" src="kuvat/rikas.png" width="160" height="172"/>
-->
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
<!--TÄSSÄ JOULUKUVA
<img class="joulukuva" alt="Joulu kuva" src="kuvat/joulu.png" width="150" height="210"/>
-->
<!--TÄSSÄ TALKOO LOOTA
<div class="tekstityyli_etusivu" id="talkooloota">
<div class="isopunanen">TALKOOT!</div><div>XXXXXXX on järjestänyt talkoot XXXXXXX 00.00.0000! Ilmoittautuneet: XXXXX, XXXXX, XXXXX. <div class="isopunanen">ILMOITTAUDU JA TIENAA PISTE!</div>
</div>
</div>-->
<!--helahoito päättyy-->
</div>
</body>
</html>

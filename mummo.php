<?php require_once 'avusteet.php';
$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

varmistaMummo($kayttaja);

    $mummon_tyolista = $mummoKyselija->mummonTyolistaKysely($kayttaja);
    $mummon_sukulaiset = $mummoKyselija->mummonSukulaiset($kayttaja);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="tyylit/tyylit_mummo.css" rel="stylesheet" type="text/css" />
<title>Perintöä odotellessa</title>
</head>

<body>
<div class="helahoito">
    <p id="otsikko">Tervetuloa <?php echo $kayttaja->nimi ?>-<?php echo $kayttaja->status ?>!</p>
    
    <?php if($kayttaja->admin){?>
        <form action="kirjaudu.php?admin" method="POST">
            <input name="admin" type="submit" class="nappula" id="nappula_admin" value="Ylläpito" />
        </form>
    <?php } ?>
    
    <form action="kirjaudu.php?ulos" method="POST">
    	<input name="kirjaudu_ulos" type="submit" class="nappula" id="nappula_ulos" value="Kirjaudu ulos" />
    </form>

    <form method="post" action="mummo_toiminnot.php">
	<table class="tyotaulu" border="1">
    	<caption class="tekstityyli_etusivu">
        	Työlista
      	</caption>
      	<tr class="taulukon_otsikoidentausta">
            <th scope="col">Työ</th>
            <th scope="col">Kuvaus</th>
            <th scope="col">Deadline</th>
            <th scope="col">Varannut</th>
            <th scope="col">Kuka teki</th>
            <th scope="col">Valitse</th>
        </tr>
        <?php foreach ($mummon_tyolista as $mummon_tyoLista){?>
            <tr>
            <td><?php echo $mummon_tyoLista["nimi"]?></td>
            <td><?php echo $mummon_tyoLista["kuvaus"]?></td>
            <td><?php echo $mummon_tyoLista["deadline"]?></td>
            <td><?php echo $mummon_tyoLista["varannut"]?></td>
            <td><?php echo $mummon_tyoLista["teki"]?></td>
            <td align="center">
                <input type="radio" name="mummonTyolista" value="<?php echo $mummon_tyoLista['id']?>"/> 
            </td>
            </tr>		
	<?php } ?>
       	</table>
            
        <p class="tekstityyli_etusivu" id="poistatyoteksti">Valitse työ listasta poistaaksesi se.</p>
    	<input name="poistaTyo" type="submit" value="Poista työ" class="nappula" id="poistatyonappi"  />
    
        <p class="tekstityyli_etusivu" id="lisaatyoteksti">Kirjoita uuden työn tiedot kenttiin. Deadline muodossa vvvv-kk-pv.</p>
    
	<table class="uusityo" border="1">
    	<caption class="tekstityyli_etusivu">
        	Lisää uusi työ
      	</caption>
      	<tr class="taulukon_otsikoidentausta">
            <th scope="col">Työ</th>
            <th scope="col">Kuvaus</th>
            <th scope="col">Deadline</th>
        </tr>
        <tr>
            <td><input class="tekstikentta" name="uusityo" type="text" maxlength="100" /></td>
            <td><input class="tekstikentta" name="uusikuvaus" type="text" maxlength="300" /></td>
            <td><input class="tekstikentta" name="uusideadline" type="text" /></td>
        </tr>
        </table>

        <input name="lisaaTyo" type="submit" value="Lisää työ" class="nappula" id="uusityonappi"  />
       
        <table class="sukulaisetlista" border="1">
            <caption class="tekstityyli_etusivu">
                <?php echo $kayttaja->nimi ?>-<?php echo $kayttaja->status ?>n kullanmurut
            </caption>
            <tr class="taulukon_otsikoidentausta">
                <th scope="col">Nimi</th>
                <th scope="col">Pisteet</th>
                <th scope="col">Valitse</th>
            </tr>
            <?php foreach ($mummon_sukulaiset as $mummin_suku){?>
            <tr>
            <td><?php echo $mummin_suku["nimi"]?></td>
            <td><?php echo $mummin_suku["pisteet"]?></td>
            <td align="center">
                <input type="radio" name="mummonSukulista" value="<?php echo $mummin_suku['id']?>"/> 
            </td>
            </tr>
            <?php } ?>
        </table>
    	       
    	<p class="tekstityyli_etusivu" id="lisaatekijateksti">Valitse sukulainen ja työ merkataksesi työntekijä.</p>
        <input name="lisaaTyontekija" type="submit" value="Lisää työn tehnyt sukulainen" class="nappula" id="lisaatekijanappi"  />
    </form>
</div><!--helahoito päättyy-->

</body>
</html>

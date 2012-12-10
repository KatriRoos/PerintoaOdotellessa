<?php require_once 'avusteet.php';
$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

    $vapaatTyot = $sukuKyselija->vapaatTyot($kayttaja);
    $varatutTyot = $sukuKyselija->haeOmatTyovaraukset($kayttaja);
    $sukulaisetLista = $sukuKyselija->haeOmatSukulaiset($kayttaja);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="tyylit/sukulainen_tyyli.css" rel="stylesheet" type="text/css" />
<title>Perintöä odotellessa</title>
</head>

<body>
<div class="helahoito">
    <p id="otsikko" class="tekstityyli_etusivu">Tervetuloa <?php echo $kayttaja->nimi ?>!</p>     
    <img id="rahanperassakuva" src="kuvat/rahanperassa.png" alt="rahanperassa juoksu-kuva" width="230" height="166"/>
    
    <!--Yläreunan painikkeet-->
    <?php if($kayttaja->admin){?>
    <form action="kirjaudu.php?admin" method="POST">
        <input name="admin" type="submit" class="nappula" id="nappula_admin" value="Ylläpito" />
    </form>
    <?php } ?>
    
    <form action="kirjaudu.php?ulos" method="POST">
        <input name="kirjaudu_ulos" type="submit" class="nappula" id="nappula_ulos" value="Kirjaudu ulos" />      
    </form>
    
    <!--Joulukuussa tulee näkyviin pistetilanne-->
    <?php if(date('M') === 'Dec')   { ?>
        <img id="talkootnappi" alt="Joulu kuva" src="kuvat/joulu.png" width="50" height="70" />
        <form method="post" action="pistetilanne.php">
            <input type="submit" value="PISTETILANNE" class="nappula" id="pistenappi" />
        </form>
        <img class="joulukuva" alt="Joulu kuva" src="kuvat/joulu.png" width="50" height="70" />
    <?php } ?>
    
    <!--Vapaat työt-->
    <form method="post" action="suku_tyo_varaus.php">
    <table class="tyotaulu" border="1" >
    	<caption class="tekstityyli_etusivu">
        	Vapaana olevat työt
      	</caption>
      	<tr class="taulukon_otsikoidentausta">
            <th scope="col">Pomo</th>
            <th scope="col">Työ</th>
            <th scope="col">Kuvaus</th>
            <th scope="col">Deadline</th>
            <th scope="col">Valitse</th>
        </tr>
        <?php foreach ($vapaatTyot as $vt){?>
            <tr>
            <td><?php echo $vt["pomo"]?></td>
            <td><?php echo $vt["nimi"]?></td>
            <td><?php echo $vt["kuvaus"]?></td>
            <td><?php echo $vt["deadline"]?></td>
            <td align="center">
                <input type="radio" name="vapaatTyot" value="<?php echo $vt['id']?>"/> 
            </td>
            </tr>
        <?php } ?>
    </table>
    
    <p class="tekstityyli_etusivu" id="varauspaivateksti">Valitse haluamasi työ ja lisää kenttään päivämäärä milloin haluat tehdä työn.</p>
  
    <!--Varaa työ-->
    <input id="varauspaivakentta" name="varauspaiva" type="text" maxlength="10" />
    
    <p class="tekstityyli_etusivu" id="varauspaivakenttateksti">Päivämäärä muodossa pv.kk.vvvv</p>
    
    <input type="submit" value="Varaa työ" class="nappula" id="varaatyonappi"  />
    </form>
    
    <!--Omat työvaraukset ja niiden poistaminen-->
    <form method="post" action="suku_poista_varaus_ja_talkoot.php">
    <table class="omatvaraukset" border="1">
    	<caption class="tekstityyli_etusivu">
        	Omat työvaraukset
      	</caption>
      	<tr class="taulukon_otsikoidentausta">
            <th scope="col">Pomo</th>
            <th scope="col">Työ</th>
            <th scope="col">Kuvaus</th>
            <th scope="col">Deadline</th>
            <th scope="col">Milloin tehdään</th>
            <th scope="col">Valitse</th>
        </tr>
        <?php foreach ($varatutTyot as $varatut){?>
        <tr>
        <td><?php echo $varatut["pomo"]?></td>    
        <td><?php echo $varatut["nimi"]?></td>
        <td><?php echo $varatut["kuvaus"]?></td>
        <td><?php echo $varatut["deadline"]?></td>
        <td><?php echo $varatut["milloin"]?>
        <?php    
            if($sukuKyselija->onkoTyoTalkoo($varatut['tyoid'])) { ?>
                <span>(Talkoot)</span>
        <?php } ?>
        </td>
        <td align="center">
            <input type="radio" name="varatutTyot" value="<?php echo $varatut['id']?>,
                <?php echo $varatut['tyoid']?>,<?php echo $varatut['pomoid']?>"/> 
        </td>
        </tr>
        <?php } ?>
    </table>   
    
    <p class="tekstityyli_etusivu" id="poistatyovarausteksti">Valitse poistettava työvaraus.</p>
    
    <input type="submit" name="poistaVaraus" value="Poista työvaraus" class="nappula" id="poistatyovarausnappi"  />        
           
    <!--Sukulaiset ja niiden lisääminen talkoisiin-->
    <table class="sukulaisetlista" border="1">
            <caption class="tekstityyli_etusivu">
                Rakkaat sukulaiset
            </caption>
            <tr class="taulukon_otsikoidentausta">
                <th scope="col">Nimi</th>
                <th scope="col">Valitse</th>
            </tr>
            <?php foreach ($sukulaisetLista as $sl){?>
            <tr>
            <td><?php echo $sl["nimi"]?></td>
            <td align="center">
                <input type="radio" name="sukulista" value="<?php echo $sl['id']?>"/> 
            </td>
            </tr>
            <?php } ?>
    </table> 
    
    <p class="tekstityyli_etusivu" id="talkootteksti">Perusta talkoot:<br/>Varaa ensin työ itsellesi. 
        Valitse sitten työ Omat työvaraukset-listasta<br/> ja sukulainen sukulaiset-listasta.<br/>
        Kun työstä on tehty talkoot, näkyy milloin-sarakkeessa teksti: talkoot.
    </p>
  
    <input type="submit" name="talkoot" value="Talkoot" class="nappula" id="talkootnappi"  />
    </form>

</div><!--helahoito päättyy-->

</body>
</html>

<?php require_once 'avusteet.php';
 
$kayttaja = $kyselija->haeKayttaja($sessio->kayttaja_id); 

varmistaAdmin($kayttaja);

$sukulaiset = $adminKyselija->haeSukulaiset($kayttaja);
$sukulaisetJaKirjautunut = $adminKyselija->haeSukulaisetJaKirjautunut();
$mummotJaKirjautunut = $adminKyselija->haeMummotJaKirjautunut();
$mummot = $adminKyselija->haeMummot($kayttaja);
$sukulaissuhteet = $adminKyselija->haeSukulaissuhteet();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="tyylit/tyylit_admin.css" rel="stylesheet" type="text/css" />
<title>Perintöä odotellessa</title>
</head>

<body>
         
<div class="helahoito">
    <p id="otsikko" class="tekstityyli_etusivu">Tervetuloa ylläpitäjä <?php echo $kayttaja->nimi ?>!</p>     
    <img id="moppauskuva" src="kuvat/moppaa.png" alt="moppaus kuva" height="108" width="108"/>
    
    <form action="kirjaudu.php?takaisin" method="POST">
        <input name="takaisin" type="submit" class="nappula" id="nappula_takaisin" value="Takaisin" />
    </form>

    <form action="kirjaudu.php?ulos" method="POST">
	<input name="kirjaudu_ulos" type="submit" class="nappula" id="nappula_ulos" value="Kirjaudu ulos" />
    </form>
    
    <form method="post" action="admin_poista_kayttaja.php">
        <table class="sukulainentaulu" border="1" >
            <caption class="tekstityyli_etusivu">
                    Sukulaiset
            </caption>
            <tr class="taulukon_otsikoidentausta">
                <th scope="col">Nimi</th>
                <th scope="col">Käyttäjätunnus</th>
                <th scope="col">Valitse</th>
            </tr>
            <?php foreach ($sukulaiset as $sukulainen){?>
                <tr>
                <td><?php echo $sukulainen["nimi"]?></td>
                <td><?php echo $sukulainen["kayttajatunnus"]?></td>
                <td align="center">
                    <input type="radio" name="sukulaiset" value="<?php echo $sukulainen['id']?>"/> 
                </td>
                </tr>		
            <?php } ?>	

        </table>
        <p class="tekstityyli_etusivu" id="poistasukuteksti">Valitse poistettava sukulainen listasta.</p>
        <input type="submit" value="Poista sukulainen" class="nappula" id="poistasukunappi"  />
    </form>
    
    <p class="tekstityyli_etusivu" id="uusikayttajateksti">Lisää uuden käyttäjän tiedot kenttiin. Jos käyttäjä on perinnönjakaja, lisää status.</p>
    <form method="post" action="admin_lisaa_kayttaja.php">
        <table class="lisaakayttajataulu" border="1">
        <caption class="tekstityyli_etusivu">
                Lisää uusi käyttäjä
        </caption>
        <tr class="taulukon_otsikoidentausta">
            <th scope="col">Nimi</th>
            <th scope="col">Käyttäjätunnus</th>
            <th scope="col">Salasana</th>
            <th scope="col">Status</th>
            <th scope="col">Ylläpitäjä</th>
        </tr>
        <tr>
            <td><input class="tekstikentta" name="uusi_nimi" type="text" maxlength="70" /></td>
            <td><input class="tekstikentta" name="uusi_kayttajatunnus" type="text" maxlength="30" /></td>
            <td><input class="tekstikentta" name="uusi_salasana" type="text" maxlength="10" /></td>
            <td><input class="tekstikentta" name="uusi_status" type="text" maxlength="30" /></td>
            <td align="center">
                    <input type="radio" name="uusi_admin" value="true" /> 
            </td>
        </tr>
        </table>   


        <input type="submit" value="Lisää käyttäjä" class="nappula" id="lisaakayttajanappi"  />
    </form>
    
    <form method="post" action="admin_poista_kayttaja.php">
        <table class="mummotaulu" border="1" >
            <caption class="tekstityyli_etusivu">
                    Mummot, papat ja muut rikkaat tyypit
            </caption>
            <tr class="taulukon_otsikoidentausta">
                    <th scope="col">Nimi</th>
                <th scope="col">Käyttäjätunnus</th>
                <th scope="col">Status</th>
                <th scope="col">Valitse</th>
            </tr>
            <?php foreach ($mummot as $mummmo){?>
                <tr>
                <td><?php echo $mummmo["nimi"]?></td>
                <td><?php echo $mummmo["kayttajatunnus"]?></td>
                <td><?php echo $mummmo["status"]?></td>
                <td align="center">
                    <input type="radio" name="sukulaiset" value="<?php echo $mummmo['id']?>"/> 
                </td>
                </tr>		
            <?php } ?>
        </table>

        <p class="tekstityyli_etusivu" id="poistamummoteksti">Valitse poistettava mummo listasta.</p>

        <input type="submit" value="Poista Mummo" class="nappula" id="poistamummonappi"  />
    </form>
    
    <form method="post" action="admin_luo_sukulaiset.php">
        <p class="tekstityyli_etusivu" id="valitse_sukulaisuussuhde_teksti">
            Valitse vasemmasta taulusta sukulainen ja oikeasta perinnönjakaja.
        </p>

        <table class="sukulaisennimitaulu" border="1" >
            <caption class="tekstityyli_etusivu">
                    Sukulaiset
            </caption>
            <tr class="taulukon_otsikoidentausta">
                <th scope="col">Nimi</th>
                <th scope="col">Valitse</th>
            </tr>
            <?php foreach ($sukulaisetJaKirjautunut as $sukulainen){?>
                <tr>
                <td><?php echo $sukulainen["nimi"]?></td>
                <td align="center">
                    <input type="radio" name="suku" value="<?php echo $sukulainen['id']?>"/> 
                </td>
                </tr>		
            <?php } ?>	

        </table>
        
        <table class="mummonnimitaulu" border="1" >
            <caption class="tekstityyli_etusivu">
                    Perinnönjakaja
            </caption>
            <tr class="taulukon_otsikoidentausta">
                <th scope="col">Nimi</th>
                <th scope="col">Valitse</th>
            </tr>
            <?php foreach ($mummotJaKirjautunut as $mummeli){?>
                <tr>
                <td><?php echo $mummeli["nimi"]?></td>
                <td align="center">
                    <input type="radio" name="mummeli" value="<?php echo $mummeli['id']?>"/> 
                </td>
                </tr>		
            <?php } ?>	
        </table>
     
        <input type="submit" value="Luo sukulaisuussuhde" class="nappula" id="sukulaisuussuhdenappi"  />
    </form>
        
    <form method="post" action="admin_poista_sukulaissuhde.php">
<!--        <p class="tekstityyli_etusivu" id="kirjoitatunnusteksti">Kirjoita henkilön käyttäjätunnus, jonka sukulaisuussuhteet haluat.</p>
            
        <input class="kayttajannimi_tekstikentta" name="kayttajannimi_tekstikentta" type="text" maxlength="70" />
    
        <input class="nappula" id="suhteetnappula" type="submit" value="Hae sukulaisuussuhteet" /> -->
        
        <table class="suhteettaulu" border="1" >
            <caption class="tekstityyli_etusivu">
                    Sukulaisuussuhteet
            </caption>
            <tr class="taulukon_otsikoidentausta">
                <th scope="col">Perinnönhaltija</th>
                <th scope="col">Sukulainen</th>
                <th scope="col">Valinta</th>
            </tr>
            <?php foreach ($sukulaissuhteet as $sukusuhteet){?>
                <tr>
                <td><?php echo $sukusuhteet["mummeli"]?></td>
                <td><?php echo $sukusuhteet["nimi"]?></td>
                <td align="center">
                    <input type="radio" name="suhteet" value="<?php echo $sukusuhteet['id']?>"/> 
                </td>
                </tr>		
            <?php } ?>	
        </table>
        
        <p class="tekstityyli_etusivu" id="poistasuhdeteksti">Valitse taulusta poistettava sukulaisuussuhde.</p>
        
        <input class="nappula" id="poistasuhteetnappula" type="submit" value="Poista sukulaisuussuhde" /> 
    
    </form>
</div><!--helahoito päättyy-->

</body>
</html>

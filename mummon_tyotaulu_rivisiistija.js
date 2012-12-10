    
//Function poistaa mummon työtaulusta toistuvat työn nimet, kuvaukset, deadlinet
//ja radiobuttonit jos työllä on useampi varaaja tai tekijä.
function poistaSamatArvot() {
    var taulu = document.getElementById('tyotaulu');
    var rivi;
    var nykyinenRivi;
    var nimi, kuvaus, deadline, varannut, teki;
    var verNimi, verKuvaus, verDeadline;

    //Käydään läpi koko taulu rivi riviltä.
    for (nykyinenRivi = 1; nykyinenRivi < taulu.rows.length; nykyinenRivi++)    {
        rivi = taulu.rows[nykyinenRivi];
        //Otetaan talteen arvot soluista joissa saattaa olla samoja arvoja.
        nimi = rivi.cells[0].innerHTML;
        kuvaus = rivi.cells[1].innerHTML;
        deadline = rivi.cells[2].innerHTML;
        
        //Käydään taulu läpi toiseen kertaan rivi riviltä alkaen seuraavasta rivistä.
        if(nykyinenRivi < (taulu.rows.length - 1)) {
            for(var i = (nykyinenRivi + 1); i < taulu.rows.length; i++)  {
                rivi = taulu.rows[i];
                //Otetaan talteen arvot seuraavan rivin soluista.
                verNimi = rivi.cells[0].innerHTML;
                verKuvaus = rivi.cells[1].innerHTML;
                verDeadline = rivi.cells[2].innerHTML;
                
                //Jos arvot ovat samat, laitetaan soluun tyhjä merkkijono.
                if(nimi === verNimi && kuvaus === verKuvaus && deadline === verDeadline)    {
                    rivi.cells[0].innerHTML = " ";
                    rivi.cells[1].innerHTML = " ";
                    rivi.cells[2].innerHTML = " ";
                    rivi.cells[5].innerHTML = " ";
                }
            }
        }        
    }
}


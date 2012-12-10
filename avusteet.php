<?php

//Apufunctioita mm. kaikenlaisen varmistamiseen.

require_once 'avusteet/kirjautumiskysely.php';
require_once 'avusteet/sessio.php';
require_once 'avusteet/Admin.php';
require_once 'avusteet/Sukulainen.php';
require_once 'avusteet/Mummo.php';

function ohjaa($osoite) {
  header("Location: $osoite");
  exit;
}

function on_kirjautunut() {
  global $sessio;
  return isset($sessio->kayttaja_id);
}

function varmista_kirjautuminen() {
  if (!on_kirjautunut()) {
    ohjaa('kirjautuminen.php');
  }
}

function varmistaAdmin($kayttaja)    {
   if(!$kayttaja->admin)    {
        die("Pääsy kielletty!");
   }
}

function varmistaMummo($kayttaja)    {
   if(!$kayttaja->status)    {
        die("Pääsy kielletty!");
   }
}

function varmistaJoulukuu()    {
   if(!date('M') === 'Dec')    {
        die("Pääsy kielletty!");
   }
}


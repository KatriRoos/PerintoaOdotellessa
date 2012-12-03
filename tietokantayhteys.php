<?php

// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO('pgsql:host=localhost;dbname=perintoa_odotellessa',"postgres","postgres");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>


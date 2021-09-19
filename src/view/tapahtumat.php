<?php 
// Ensimmäinen rivi kertoo, että sivun pohjana tullaan
// käyttämään template-tiedostossa olevaa pohjaa
// ja sille välitetään tieto otsikosta.
$this->layout('template', ['title' => 'Tulevat tapahtumat']) 
// Loput sivun koodista sijoitetaan sivun sisällöksi 
// sivupohjan (template.php) section('content')-kohtaan.
?>

<h1>Tulevat tapahtumat</h1>
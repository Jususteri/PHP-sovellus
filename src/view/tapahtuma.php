<?php 
//Tämän koodin pohjalta tullaan luomaan tapahtumat-sivu. 
// Ensimmäinen rivi kertoo, että sivun pohjana tullaan käyttämään 
// template-tiedostossa olevaa pohjaa ja sille välitetään tieto otsikosta.
// Loput sivun koodista sijoitetaan sivun sisällöksi sivupohjan 
// section('content')-kohtaan.
$this->layout('template', ['title' => 'Tapahtuma']) ?>

<h1>Tapahtuma</h1>
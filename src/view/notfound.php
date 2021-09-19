<?php 
//Tämän koodin pohjalta tullaan luomaan tapahtumat-sivu. 
// Ensimmäinen rivi kertoo, että sivun pohjana tullaan käyttämään 
// template-tiedostossa olevaa pohjaa ja sille välitetään tieto otsikosta.
// Loput sivun koodista sijoitetaan sivun sisällöksi sivupohjan 
// section('content')-kohtaan.
$this->layout('template', ['title' => 'Sivua ei löytynyt']) ?>

<h1>Huppista!</h1>
<p>Valitettavasti pyytämääsi sivua ei ole. Ole hyvä ja tarkista sivun osoite.</p>
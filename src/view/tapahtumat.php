<?php 
// Ensimmäinen rivi kertoo, että sivun pohjana tullaan
// käyttämään template-tiedostossa olevaa pohjaa
// ja sille välitetään tieto otsikosta.
$this->layout('template', ['title' => 'Tulevat tapahtumat']) 
// Loput sivun koodista sijoitetaan sivun sisällöksi 
// sivupohjan (template.php) section('content')-kohtaan.
?>

<h1>Tulevat tapahtumat</h1>
<div class='tapahtumat'>
<?php
// PHP-koodilohko, joka käy tapahtumat yksi 
// kerrallaan lävitse ja tulostaa tapahtumasta div-kokonaisuuden sisältöineen.
foreach ($tapahtumat as $tapahtuma) {

  $start = new DateTime($tapahtuma['tap_alkaa']);
  $end = new DateTime($tapahtuma['tap_loppuu']);

  echo "<div>";
    echo "<div>$tapahtuma[nimi]</div>";
    echo "<div>" . $start->format('j.n.Y') . "-" . $end->format('j.n.Y') . "</div>";
    echo "<div><a href='tapahtuma?id=" . $tapahtuma['idtapahtuma'] . "'>TIEDOT</a></div>";
  echo "</div>";

}

?>
</div>
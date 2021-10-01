<?php
 // Tämä PHP-tiedosto lataa kaikki tarvittavat määritykset ja 
 // toiminnallisuudet ennen, kuin skriptiä aloitetaan suorittamaan.
  require_once '../config/config.php';

  // Composer-paketit hyödyntävät autoload-skriptiä, joka huolehtii, 
  // että kaikki sovelluksessa tarvittavat luokat tulevat ladattua ennen käyttöä.
  require_once '../vendor/autoload.php';


  require_once HELPERS_DIR . 'form.php';
  require_once HELPERS_DIR . 'DB.php';
?>
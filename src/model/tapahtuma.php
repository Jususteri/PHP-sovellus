<?php

  require_once HELPERS_DIR . 'DB.php';

   // Tämä esittelee haeTapahtumat-funktion, joka hakee tietokannasta
   // kaikki tapahtumat tapahtuman aloitusajan mukaan järjestettynä. 
   // Funktio palauttaa tapahtumat taulukkona.
  function haeTapahtumat() {
    return DB::run('SELECT * FROM tapahtuma ORDER BY tap_alkaa;')->fetchAll();
  }
  
  function haeTapahtuma($id) {
    return DB::run('SELECT * FROM tapahtuma WHERE idtapahtuma = ?;',[$id])->fetch();
  }


?>
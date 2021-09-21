<?php

// Tämä esittelee $config-nimisen taulukon
// ja antaa arvoksi projektissa käytettävät arvot.

$config = array(
    "db" => array(
       "dbname" => $_SERVER["DB_DATABASE"],
       "username" => $_SERVER["DB_USERNAME"],
       "password" => $_SERVER["DB_PASSWORD"],
       "host" => "localhost"
    ),
    "urls" => array(
      "baseUrl" => "/~jluomanm/lanify"
    )
  );

  // Tämä koodi määrittelee joukon vakioita, 
  // joissa määritellään hakemistopolut sovelluksen eri palikoille.
  define("PROJECT_ROOT", dirname(__DIR__) . "/");
  define("HELPERS_DIR", PROJECT_ROOT . "src/helpers/");
  define("TEMPLATE_DIR", PROJECT_ROOT . "src/view/");
  define("MODEL_DIR", PROJECT_ROOT . "src/model/");
  define("CONTROLLER_DIR", PROJECT_ROOT . "src/controller/");
  define("BASEURL", $config['urls']['baseUrl']);

?>
<?php

// Suoritetaan projektin alustusskripti nimeltä init.php.
// init.php ajaa aluksi config kansiosta config.php:n ja näin ottaa
// koko sovellusta koskevat asetukset käyttöön. 
// Sen jälkeen init.php kutsuu vendor kansiosta autoload.php:tä ja ajaa sen
require_once '../src/init.php';

  // Osoitteen alusta poistetaan teksti, joka
  // on määritelty config-asetuksissa.

  // config.php:ssä on määritelty, että baseUrl = /~jluomanm/lanify/public
  // $_SERVER['REQUEST_URI'] = URI joka annettiin päästäkseen tälle sivulle
  $request = str_replace($config['urls']['baseUrl'],'',$_SERVER['REQUEST_URI']);
 
  // Tässä poistetaan vielä selaimelta tulleesta pyynnöstä urlin lopussa
  // olevat parametrit, jotka erotetaan ?-merkillä osoitteesta. 
  // Jos edellisen vaiheen jälkeen pyyntö on muotoa /tapahtuma?id=1, 
  // niin tämän vaiheen jälkeen on jäljellä /tapahtuma.
  $request = strtok($request, '?');

  
   // config.php:ssä on määritelty, että TEMPLATE_DIR = src/view. 
   // Seuraavaksi luodaan uusi plates-olio ja kytketään se sivupohjiin, eli 
   // Näkymä(View).
   $templates = new League\Plates\Engine(TEMPLATE_DIR);

  // Selvitetään ehtolauseilla mitä sivua on kutsuttu 
  // ja suoritetaan sivua vastaava käsittelijä.
  switch ($request) {
    case '/':
    case '/tapahtumat':
      require_once MODEL_DIR . 'tapahtuma.php';
      $tapahtumat = haeTapahtumat();
      echo $templates->render('tapahtumat',['tapahtumat' => $tapahtumat]);
      break;
    case '/tapahtuma':
      require_once MODEL_DIR . 'tapahtuma.php';
      $tapahtuma = haeTapahtuma($_GET['id']);
      if ($tapahtuma) {
        echo $templates->render('tapahtuma',['tapahtuma' => $tapahtuma]);
      } else {
        echo $templates->render('tapahtumanotfound');
      }
      break;
      case '/lisaa_tili':
        if (isset($_POST['laheta'])) {
          $formdata = cleanArrayData($_POST);
          require_once CONTROLLER_DIR . 'tili.php';
          $tulos = lisaaTili($formdata);
        
          if ($tulos['status'] == "200") {
            echo "Tili on luotu tunnisteella $tulos[id]";
            break;
          }
          echo $templates->render('tili_lisaa', ['formdata' => $formdata, 'error' => $tulos['error']]);
          break;
        } else {
          echo $templates->render('tili_lisaa', ['formdata' => [], 'error' => []]);
          break;
        }  
    default:
      echo $templates->render('notfound');
  }    

?> 
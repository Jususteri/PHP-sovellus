<?php

    // Aloitetaan istunnot.
    session_start();

// Suoritetaan projektin alustusskripti nimeltä init.php.
// init.php ajaa aluksi config kansiosta config.php:n ja näin ottaa
// koko sovellusta koskevat asetukset käyttöön. 
// Sen jälkeen init.php kutsuu vendor kansiosta autoload.php:tä ja ajaa sen
require_once '../src/init.php';


  // Haetaan kirjautuneen käyttäjän tiedot.
  if (isset($_SESSION['user'])) {
    require_once MODEL_DIR . 'henkilo.php';
    $loggeduser = haeHenkilo($_SESSION['user']);
  } else {
    $loggeduser = NULL;
  }


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
          require_once MODEL_DIR . 'ilmoittautuminen.php';
          $tapahtuma = haeTapahtuma($_GET['id']);
          if ($tapahtuma) {
            if ($loggeduser) {
              $ilmoittautuminen = haeIlmoittautuminen($loggeduser['idhenkilo'],$tapahtuma['idtapahtuma']);
            } else {
              $ilmoittautuminen = NULL;
            }
            echo $templates->render('tapahtuma',['tapahtuma' => $tapahtuma,
                                                 'ilmoittautuminen' => $ilmoittautuminen,
                                                 'loggeduser' => $loggeduser]);
          } else {
            echo $templates->render('tapahtumanotfound');
          }
          break;
          case "/kirjaudu":
            if (isset($_POST['laheta'])) {
              require_once CONTROLLER_DIR . 'kirjaudu.php';
              if (tarkistaKirjautuminen($_POST['email'],$_POST['salasana'])) {
                require_once MODEL_DIR . 'henkilo.php';
                $user = haeHenkilo($_POST['email']);
                if ($user['vahvistettu']) {
                  session_regenerate_id();
                  $_SESSION['user'] = $user['email'];
                  header("Location: " . $config['urls']['baseUrl']);
                } else {
                  echo $templates->render('kirjaudu', [ 'error' => ['virhe' => 'Tili on vahvistamatta! Ole hyvä, ja vahvista tili sähköpostissa olevalla linkillä.']]);
                }
              } else {
                echo $templates->render('kirjaudu', [ 'error' => ['virhe' => 'Väärä käyttäjätunnus tai salasana!']]);
              }
            } else {
              echo $templates->render('kirjaudu', [ 'error' => []]);
            }
            break;
          case '/ilmoittaudu':
            if ($_GET['id']) {
              require_once MODEL_DIR . 'ilmoittautuminen.php';
              $idtapahtuma = $_GET['id'];
              if ($loggeduser) {
                lisaaIlmoittautuminen($loggeduser['idhenkilo'],$idtapahtuma);
              }
              header("Location: tapahtuma?id=$idtapahtuma");
            } else {
              header("Location: tapahtumat");
            }
            break;
            case '/peru':
              if ($_GET['id']) {
                require_once MODEL_DIR . 'ilmoittautuminen.php';
                $idtapahtuma = $_GET['id'];
                if ($loggeduser) {
                  poistaIlmoittautuminen($loggeduser['idhenkilo'],$idtapahtuma);
                }
                header("Location: tapahtuma?id=$idtapahtuma");
              } else {
                header("Location: tapahtumat");  
              }
              break;
              case '/lisaa_tili':
                if (isset($_POST['laheta'])) {
                  $formdata = cleanArrayData($_POST);
                  require_once CONTROLLER_DIR . 'tili.php';
                  $tulos = lisaaTili($formdata,$config['urls']['baseUrl']);
          if ($tulos['status'] == "200") {
            echo $templates->render('tili_luotu', ['formdata' => $formdata]);
            break;
          }
          echo $templates->render('tili_lisaa', ['formdata' => $formdata, 'error' => $tulos['error']]);
          break;
        } else {
          echo $templates->render('tili_lisaa', ['formdata' => [], 'error' => []]);
          break;
        } 
        case "/vahvista":
          if (isset($_GET['key'])) {
            $key = $_GET['key'];
            require_once MODEL_DIR . 'henkilo.php';
            if (vahvistaTili($key)) {
              echo $templates->render('tili_aktivoitu');
            } else {
              echo $templates->render('tili_aktivointi_virhe');
            }
          } else {
            header("Location: " . $config['urls']['baseUrl']);
          }
          break;    
        case "/logout":
          require_once CONTROLLER_DIR . 'kirjaudu.php';
          logout();
          header("Location: " . $config['urls']['baseUrl']);
          break;
    default:
      echo $templates->render('notfound');
  }    

?> 
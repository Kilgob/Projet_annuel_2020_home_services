<?php
  session_start();
  include 'config.php';

  // echo $_GET['date'] . '</br>';
  // echo strtotime($_GET['date']) . '</br>';
  // echo time();

  if (isset($_GET['date']) && strtotime($_GET['date']) >= time()) {
    $context = stream_context_create(array(
        'http' => array(
            'method' => "GET",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    $json = file_get_contents('http://' . $_SESSION['ip_agence'] . '/abonnement?idabo=' . $_SESSION['idTabAbonnement'], false, $context);
    $abonnement = json_decode($json, true);

    $json = file_get_contents('http://' . $GLOBALS['IP_SIEGE'] . '/unique_abonnement?idabo=' . $abonnement['data'][0]['idabonnement'], false, $context);
    $unique_abonnement = json_decode($json, true);

    $json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/unique_service?service=" . $_GET['service'], false, $context);
    $unique_service = json_decode($json, true);

    // echo 'Ma date : ' . date("D", strtotime($_GET['date']));
    $nbrDispoDays = $unique_abonnement['data'][0]['nbrdispojour'];
    $ma_date = date("D", strtotime($_GET['date']));

    switch ($nbrDispoDays) {
        case 1:
            if ($ma_date == "Sat") {
              echo "Cliquez sur confirmer afin de valider votre choix";
            }
            else {
              echo "Un surplus de " . $unique_service['data'][0]['prix'] . "€ vous sera demandé !";
            }
            break;
        case 2:
            if ($ma_date == "Sat" || $ma_date == "Sun") {
              echo "Cliquez sur confirmer afin de valider votre choix";
            }
            else {
              echo "Un surplus de " . $unique_service['data'][0]['prix'] . "€ vous sera demandé !";
            }
            break;
        case 3:
            if ($ma_date == "Sat" || $ma_date == "Sun" || $ma_date == "Wed") {
              echo "Cliquez sur confirmer afin de valider votre choix";
            }
            else {
              echo "Un surplus de " . $unique_service['data'][0]['prix'] . "€ vous sera demandé !";
            }
            break;
        case 4:
            if ($ma_date != "Sat" && $ma_date != "Sun" && $ma_date != "Wed") {
                echo "Cliquez sur confirmer afin de valider votre choix";
            }
            else {
              echo "Un surplus de " . $unique_service['data'][0]['prix'] . "€ vous sera demandé !";
            }
            break;
        case 5:
            if ($ma_date != "Sat" && $ma_date != "Sun") {
              echo "Cliquez sur confirmer afin de valider votre choix";
            }
            else {
              echo "Un surplus de " . $unique_service['data'][0]['prix'] . "€ vous sera demandé !";
            }
            break;
        case 6:
            if ($ma_date != "Sat") {
              echo "Cliquez sur confirmer afin de valider votre choix";
            }
            else {
              echo "Un surplus de " . $unique_service['data'][0]['prix'] . "€ vous sera demandé !";
            }
            break;
        case 7:
            echo "Cliquez sur confirmer afin de valider votre choix";
            break;
        default:
          break;
        }
      }
      else {
        echo "La date est dépassée !";
      }


      if (isset($_GET['description'])) {

        $context = stream_context_create(array(
            'http' => array(
                'method' => "POST",
                'header' => "Authorization: Basic " . base64_encode("user:pass"))
        ));

        $description = str_replace("'", "%27", $_GET['description']);

        $json = file_get_contents(str_replace(" ", "%20", "http://" . $_SESSION['ip_agence'] . "/deviscli?idservice="
            . $_GET['idservice'] .
            "&iduser=" . $_SESSION['nmuser'] .
            "&idservice=" . $_GET['idservice'] .
            "&dtcrea=" . $_GET['date'] .
            "&description=" . $description .
            "&idcateg=" . $_GET['id_categ']
            )
            ,false,$context);

      }
  //   if ($unique_abonnement['data'][0]['nbrdispojour'] == 5) {
  //     if (date("D", strtotime($_GET['date'])) == 'Sat' || date("D", strtotime($_GET['date'])) == 'Sun') {
  //       $json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/unique_service?service=" . $_GET['service'], false, $context);
  //       $unique_service = json_decode($json, true);
  //
  //       echo 'Attention ! Votre abonnement ne comprend pas les jours non ouvrés'$unique_service['data'][0]['prix'];
  //     }
  //   }
  //   else if ($unique_abonnement['data'][0]['nbrdispojour'] == 6) {
  //     if (date("D", strtotime($_GET['date'])) == 'Sat')
  //   }
  // }

  //
  // $context = stream_context_create(array(
  //     'http' => array(
  //         'method' => "POST",
  //         'header' => "Authorization: Basic " . base64_encode("user:pass"))
  // ));
  //
  // $clock = $_POST['date'] . '%20' . $ampm . $_POST['clock'] .  ':00';
  //
  // $json = file_get_contents(str_replace(" ", "%20", "http://" . $_SESSION['ip_agence'] . "/deviscli?idservice="
  //     . $_POST['service'] .
  //     "&iduser=" . $_SESSION['nmuser'] .
  //     "&idservice=" . $_POST['service'] .
  //     "&dtcrea=" . $clock .
  //     "&description=" . $_POST['description'] .
  //     "&idcateg=" . $_POST['categService']
  //     )
  //     ,false,$context);
  //
  // header('Location: rdv_service.php?error=succes');
  // exit;
?>

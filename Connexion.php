<?php
  session_start();
  include 'config.php';
  require_once 'VerificationAbonnement.php';

  if($_POST['agence_selected'] == NULL){
    header('Location: ConnexionIndex.php?error=no_agence_selected');
    exit;
  }


  $context = stream_context_create(array(
    'http' => array(
    'header'  => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  $json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence_get_ip?idagence=" . $_POST['agence_selected'], false, $context);
  $agence_infos = json_decode($json, true);
  $ip_agence = $agence_infos['data'][0]['ip'] . ":" . $agence_infos['data'][0]['port'];

  //Récupération des informations de connexion
  $json = file_get_contents("http://" . $ip_agence . "/client?email=" . $_POST['username'] . "&password=" . $_POST['password'], false, $context);
  $connection_infos = json_decode($json, true);

  //Récupération des informations personnelles de l'utilisateur
  $json = file_get_contents("http://" . $ip_agence . "/SelectClient?iduser=" . $connection_infos['data'][0]['iduser'], false, $context);
  $user_infos = json_decode($json, true);

  if($connection_infos != NULL && $connection_infos['data'][0]['okactif'] == 0){
   header('Location: ConnexionIndex.php?error=disabled');
   exit;
  }

  if($connection_infos['data'][0]['iduser'] != NULL){
    $_SESSION['nmuser'] = $connection_infos['data'][0]['iduser'];
    $_SESSION['cdtype_user'] = $connection_infos['data'][0]['cdtype_user'];
    $_SESSION['okactif'] = $connection_infos['data'][0]['okactif'];//à checker
    $_SESSION['idcategservice'] = $connection_infos['data'][0]['idcategservice'];//à checker
    $_SESSION['ip_agence'] = $ip_agence;
    $_SESSION['idTabAbonnement'] = $connection_infos['data'][0]['idtababonnement'];
    //Si le client n'a pas d'abo, la prochaine fois qu'il choisira un service,
    // cette variable passera à 2 signifiant qu'il doit payer son service avant
    // dans choisir un nouveau

    //include 'checkSpent.php';

    //Vérifier le statut de l'abonnement
    $user_abonnement = new VerificationAbonnement($_SESSION['idTabAbonnement'], $_SESSION['nmuser']);

    if ($user_abonnement->checkEndDate() == true && $user_infos['data'][0]['statutabo'] == 1) {
      $user_abonnement->updateStatut();
      $user_abonnement->calculPrix();
      $user_abonnement->generateFacture();
    }


    header('Location: index.php');
    exit;
  }
  else{
    header('Location: ConnexionIndex.php?error=account_missing');
    exit;
  }


?>

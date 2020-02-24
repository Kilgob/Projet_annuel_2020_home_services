<?php

  include 'config.php';
  session_start();


  $context = stream_context_create(array(
    'http' => array(
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
  ));
  $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence_get_ip?idagence=" . $_POST['agence_selected'], false, $context);
  $user_infos=json_decode($json, true);
  $ip_agence = $user_infos['data'][0]['ip'] . ":" . $user_infos['data'][0]['port'];
//  echo "http://" . $ip_agence . "/mysql2?email=" . $_POST['username'] . "&password=" . $_POST['password'];
  $json=file_get_contents("http://" . $ip_agence . "/client?email=" . $_POST['username'] . "&password=" . $_POST['password'], false, $context);
  $user_infos=json_decode($json, true);
//echo $user_infos['data'][0]['mail'];

// ['data'][0]['iduser']
  if($user_infos != NULL && $user_infos['data'][0]['okactif'] == 0){
   header('Location: ConnexionIndex.php?error=disabled');
   exit;
  }

  if($user_infos['data'][0]['iduser'] != NULL){
    $_SESSION['nmuser'] = $user_infos['data'][0]['iduser'];
    $_SESSION['cdtype_user'] = $user_infos['data'][0]['cdtype_user'];
    $_SESSION['okactif'] = $user_infos['data'][0]['okactif'];//à checker
    $_SESSION['idcategservice'] = $user_infos['data'][0]['idcategservice'];//à checker
    $_SESSION['ip_agence'] = $ip_agence;
    //Si le client n'a pas d'abo, la prochaine fois qu'il choisira un service,
    // cette variable passera à -1 signifiant qu'il doit payer son service avant
    // dans choisir un nouveau
    $_SESSION['cdabonement'] = $user_infos['data'][0]['idabonnement'];

    //include 'checkSpent.php';

    header('Location: index.php');
    exit;
  }
  else{
    header('Location: ConnexionIndex.php?error=account_missing');
    exit;
  }


?>

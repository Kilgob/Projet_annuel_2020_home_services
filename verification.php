<?php
  session_start();
  include 'config.php';



  $firstname = trim($_POST['firstname']);
  $lastname = trim($_POST['lastname']);
  $email = trim($_POST['email']);
  $confirm_email = trim($_POST['confirm_email']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);
  $address = trim($_POST['address']);
  $birthday = $_POST['birthday'];
  $gender = $_POST['gender'];
  //$country = $_POST['country'];
  $num_tel = trim($_POST['num_tel']);
  $town = $_POST['town'];
  $address = trim($_POST['address']);
  $verif_captcha = $_POST['verif_captcha'];
  $token = 'CFQ' . hash('sha256',$email);

  // Verification de l'email dans le POST
  if(!isset($email) || empty($email)){
    header('Location: inscription.php?error=email_missing');
    exit;
  }

  //Verification du format de l'email
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header('Location: inscription.php?error=email_format');
    exit;
  }

  //Verification email déjà existante ?
  $context = stream_context_create(array(
      'http' => array(
          'method' => "GET",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence_get_ip?idagence=" . $_POST['agence_selected'], false, $context);
  $decode =json_decode($json, true);
  $ip_agence = $decode['data'][0]['ip'] . ":" . $decode['data'][0]['port'];

  $requete = "http://" . $ip_agence . "/register_count?mail=" . $email;
  $json = file_get_contents($requete, false, $context);
  $returnNbUser = json_decode($json, true);

  if($returnNbUser['data'][0]['nb_user'] != 0){
    header('Location: inscription.php?error=email_taken');
    exit;
  }

  if($email != $confirm_email){
    header('Location: inscription.php?error=email_not_corresponding');
    exit;
  }

  //PRENOM & NOM

  if(empty($firstname)){
    header('Location: inscription.php?error=firstname_missing');
    exit;
  }

  if(empty($lastname)){
    header('Location: inscription.php?error=lastname_missing');
  }
  // PASSWORD

  if(empty($password)){
    header('Location: inscription.php?error=password_missing');
    exit;
  }

  if(strlen($password) < 6){
    header('Location: inscription.php?error=password_length');
    exit;
  }

  if($password != $confirm_password){
    header('Location: inscription.php?error=password_not_corresponding');
    exit;
  }

  // COUNTRY

  // if(!isset($country) || empty($country) || $country == 'pays'){
  //   header('Location: inscription.php?error=country_missing');
  //   exit;
  // }

  // GENDER

  if(!isset($gender) || empty($gender)){
    header('Location: inscription.php?error=gender_missing');
    exit;
  }

  //BIRTHDAY

  if(!isset($birthday) || empty($birthday)){
    header('Location: inscription.php?error=birthday_missing');
    exit;
  }

  //ADDRESS

  if(!isset($address) || empty($address)){
    header('Location: inscription.php?error=address_missing');
    exit;
  }

  //TOWN

  if(!isset($town) || empty($town)){
    header('Location: inscription.php?error=town_missing');
  }

  //VERIFICATION NUMERO DE TEL

  if(!isset($num_tel) || empty($num_tel)){
    header('Location: inscription.php?error=num_tel_missing');
    exit;
  }

  // VERIFIFCATION CAPTCHA

  if($_SESSION['captcha'] != $verif_captcha){
    header('Location: inscription.php?error=captcha_novalide');
    exit;
  }


  $context = stream_context_create(array(
      'http' => array(
          'method' => "POST",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  $requete = "http://" . $ip_agence . "/client?nom=" . $lastname .
      "&prenom=" . $firstname .
      "&mail=" . $email .
      "&notel=" . $num_tel .
      "&password=" . hash("sha256", $password) .
      "&adresse=" . $address .
      "&ville=" . $town .
      "&cdtype_user=cli" .
      "&idabonnement=0";
  $requete = str_replace(" ", "%20", $requete);

  $json = file_get_contents($requete, false, $context);

  //include 'emailSend.php';
  //Redirection vers la page

  header('Location: ConnexionIndex.php');
  exit;
?>

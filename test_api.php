<?php

include_once("./lang.php");
/*date_default_timezone_set("Europe/Paris");

if(!isset($_SESSION['nmuser'])){
  header('Location: index.php');
  exit;
}*/

  $context = stream_context_create(array(
    'http' => array(
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));

  $json=file_get_contents("http://172.16.69.181:6002/mysql2?email=fred@gmail.com&password=toto", false, $context);

  $parsee=json_decode($json, true);

  var_dump($parsee);

  echo '<p> id de l\'user :' . $parsee['data'][0]['iduser'] . ' </p>';
//  echo '<p>' . $parse2['idadresse'] . ' </p>';
  //echo '<p>' . $parse2['okactif'] . ' </p>';

  foreach ($parsee['data'] as $result) {
    echo '<p>' . $result['iduser'] . ' </p>';
    echo '<p>' . $result['idadresse'] . ' </p>';
    echo '<p>' . $result['okactif'] . ' </p>';
  }


  $json=file_get_contents("http://172.16.69.181:6002/user?iduser=1", false, $context);
  $user_infos=json_decode($json, true);
  echo '<p> '.t("nom de l'user").' :' . $user_infos['data'][0]['nom'] . ' </p>';
?>

<?php

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));

$json = file_get_contents("http://" . $_GET['agence'] . "/SelectClient?iduser=" . $_GET['id'], false, $context);
$user_infos = json_decode($json, true);

if ($user_infos != []) {
  echo "Prenom : " . $user_infos['data'][0]['prenom'] . "</br>";
  echo "Nom : " . $user_infos['data'][0]['nom'] . "</br>";
}
else {
  echo "Le prestataire n'est plus reference chez nous !";
}

?>

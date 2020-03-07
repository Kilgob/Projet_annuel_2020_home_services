<?php

include 'config.php';
session_start();

$context = stream_context_create(array(
    'http' => array(
        'method' => "PUT",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));


$requete = "http://" . $_SESSION['ip_agence'] . "/client?" .
    "&iduser=" . $_POST['delete_abo'];

$json=file_get_contents($requete, false, $context);
$user_infos=json_decode($json, true);


//if(1){//chnager la condition
//    echo "suppression de l'abonnemnt effectué !";
if($_SESSION['cdtype_user'] == 'cli'){
    header('Location: manage_my_account.php?error=delete_ok');
    exit;
}
    header('Location: prestataire.php');
    exit;
//}
//else{
//    echo "Erreur lors de la suppression de l'abonnemennt !";
//    header('Location: prestataire.php');
//    exit;
//}

?>
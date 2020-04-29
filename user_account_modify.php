<?php
session_start();
if ($_POST['firstName'] != NULL
    && $_POST['lastName'] != NULL
    && $_POST['addrmail'] != NULL
    && $_POST['name_rue'] != NULL
    && $_POST['lbcity'] != NULL
    && $_POST['notel'] != NULL){
    $context = stream_context_create(array(
        'http' => array(
            'method' => "PUT",
            'header'  => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    $json = file_get_contents(str_replace(" ", "%20","http://" . $_SESSION['ip_agence'] . "/user?iduser=" . $_SESSION['nmuser'] .
        "&nom=" . $_POST['lastName'] .
        "&prenom=" . $_POST['firstName'] .
        "&mail=" . $_POST['addrmail'] .
        "&notel=" . $_POST['notel'] .
        "&password=" . $_SESSION['pass'] .
        "&idcategservice=" . $_SESSION['idcategservice'] .
        "&adresse=" . $_POST['name_rue'] .
        "&ville=" . $_POST['lbcity'] .
        "&cdtype_user=" . $_SESSION['cdtype_user'] .
        "&idabonnement=" . $_SESSION['idTabAbonnement'] .
        "&okactif=1")
        , false, $context);
    header('Location: user_profil.php?error=ok');
    exit;
}

header('Location: user_profil.php?error=notok');
exit;

?>
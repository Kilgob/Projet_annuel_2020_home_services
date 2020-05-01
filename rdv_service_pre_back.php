<?php
session_start();
if ($_POST['price'] != NULL
    && $_POST['timer'] != NULL){
    $context = stream_context_create(array(
        'http' => array(
            'method' => "PUT",
            'header'  => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    $json = file_get_contents(str_replace(" ", "%20","http://" . $_SESSION['ip_agence'] .
            "/devispre?iddevis=" . $_POST['iddevis'] .
            "&statut=1" .
            "&prix=" . $_POST['price'] .
            "&temps=" . $_POST['timer'])
        , false, $context);

    $json = file_get_contents(str_replace(" ", "%20","http://" . $_SESSION['ip_agence'] .
            "/devis?iddevis=" . $_POST['iddevis'] .
            "&statutdevis=2")
        , false, $context);
    header('Location: rdv_service_pre.php?error=ok');
    exit;
}

header('Location: rdv_service_pre.php?error=notok');
exit;

?>
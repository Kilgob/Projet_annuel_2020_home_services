<?php

session_start();

$context = stream_context_create(array(
    'http' => array(
        'method' => "PUT",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

$json = file_get_contents(str_replace(" ", "%20", "http://" . $_SESSION['ip_agence'] .
    "/intervention_deb?id=" . $_POST['idintervention']), false, $context);

header('Location: rdv_service_total_pre.php');

?>
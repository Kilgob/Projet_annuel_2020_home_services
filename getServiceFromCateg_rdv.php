<?php

include 'config.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

if ($_GET['id'] != '') {
    $requete = "http://" . $GLOBALS['IP_SIEGE'] . "/select_service_from_categ?idcatservice=" . $_GET['id'];
    $json = file_get_contents($requete, false, $context);
    $liste_service = json_decode($json, true);

    foreach ($liste_service["data"] as $service) {
        echo "<input type='radio' name='service' value='" . $service["idservice"] . "'/>" . $service["lb"] . "</input><br>";
    }
}
?>
<?php
    $context = stream_context_create(array(
        'http' => array(
            'method' => "GET",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/deviscli?iduser=" . $_GET['id'], false, $context);
    $devis = json_decode($json, true);

?>


<input type="hidden" value="<?php echo $devis['data'][0]['idprestataire']; ?>" name="idpresta">
<input type="hidden" value="<?php echo $devis['data'][0]['idservice']; ?>" name="idservice">
<input type="hidden" value="<?php echo $devis['data'][0]['dtcrea']; ?>" name="dtcrea">
<input type="hidden" value="<?php echo $devis['data'][0]['prix']; ?>" id="montant" name="montant">
<input type="hidden" value="<?php echo $devis['data'][0]['description']; ?>" id="description" name="description">
<input type="hidden" id="iddevis" name="iddevis" value="<?php echo $devis['data'][0]['iddevis']; ?>">
<input type="submit" value="Valider l'intervention"/>
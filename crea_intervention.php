<?php
session_start();

  $context = stream_context_create(array(
      'http' => array(
          'method' => "GET",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/unique_devis?iddevis=" . $_POST['iddevis'], false, $context);
  $unique_devis = json_decode($json, true);

  if ($unique_devis['data'][0]['statutdevis'] == 1){

    $context = stream_context_create(array(
        'http' => array(
            'method' => "POST",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    $json = file_get_contents(str_replace(" ", "%20", "http://" . $_SESSION['ip_agence'] .
            "/intervention?iduser=" . $_SESSION['nmuser'] .
            "&idprestataire=" . $_POST['idpresta'] .
            "&idservice=" . $_POST['idservice'] .
            "&dtcrea=" . $_POST['dtcrea'] .
            "&description=" . $_POST['description'] .
            "&montant=" . $_POST['montant'] .
            "&montanthf=" . $_POST['montanthf']
        )
        , false, $context);



    $context = stream_context_create(array(
      'http' => array(
      'method' => "PUT",
      'header'  => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    $json = file_get_contents(str_replace(" ", "%20","http://" . $_SESSION['ip_agence'] .
            "/deviscli?iddevis=" . $_POST['iddevis'] .
            "&statutdevis=2")
        , false, $context);

    header('Location: devis.php?error=succes');
    exit;

  }
  else {
    header('Location: devis.php?error=no_valide');
    exit;
  }



?>

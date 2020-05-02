<?php
session_start();

if ($_POST['montant'] != ''){

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

}

header('Location: devis.php?error=succes');
exit;

?>

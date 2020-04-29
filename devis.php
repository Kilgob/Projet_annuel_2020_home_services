<?php
  include 'header.php';
  include 'config.php';

  $context = stream_context_create(array(
      'http' => array(
          'method' => "GET",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/deviscli?iduser=" . $_SESSION['nmuser'], false, $context);
  $listing_devis = json_decode($json, true);

  $json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/service", false, $context);
  $listing_service = json_decode($json, true);
  //echo $listing_devis['data'][0]['iduser'];
  ?>

  <div class="container">
    <div class="list-group">
      <?php
        if($listing_devis != []){
          foreach ($listing_devis['data'] as $devis) {
            ?>
            <li class="list-group-item">
              <?php foreach ($listing_service['data'] as $service) {
                if($service['idservice'] == $devis['idservice']) {
                  echo 'Nom du service : ' . $service['lb'] . '<br>';
                }
              } ?>
            </li>
    <?php
          }
        }
        else{
          echo 'Aucun devis en cours';
        }
        ?>
    </div>
  </div>

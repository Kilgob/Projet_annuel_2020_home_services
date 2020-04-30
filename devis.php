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
            <li class="list-group-item"  data-toggle="modal" data-target="#devismodal" data-whatever="@mdo" onclick="deviscli(<?php echo $devis['iddevis'];?>)">
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


</div>

<div class="modal fade" id="devismodal" tabindex="-1" role="dialog" aria-labelledby="iddossier_lb" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iddossier_lb">Devis en attente de validation</h5>
                <form method="POST" action="crea_intervention.php" id="form_devis" >
                    <p value="" id="timer" name="timer">temps de l'intervention : </p>
                    <p value="" id="price" name="price">prix de l'intervention : </p>
                    <input type="hidden" value="" name="idpresta">
                    <input type="hidden" value="" name="idservice">
                    <input type="hidden" value="" name="dtcrea">
                    <input type="hidden" value="" id="montanhf" name="montanthf">
                    <input type="hidden" value="" id="description" name="description">
                    <input type="hidden" id="iddevis" name="iddevis" value="">
                    <input type="submit" value="Valider l'intervention"/>
                </form>
            </div>
            <div class="modal-body" id="history">
                <!-- Display history -->
            </div>
        </div>
    </div>
</div>
<script src="rdv_service.js"></script>

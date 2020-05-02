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
    <div class="list-group justify-content-center">
      <div class="row d-flex justify-content-center">
        <section id="form-elegant-devis">
          <div class="card">
            <nav>
              <ul class="nav nav-pills flex-column">
      <?php
        if($listing_devis != []){
          foreach ($listing_devis['data'] as $devis) {
            ?>
            <li class="list-group-item d-flex"  data-toggle="modal" data-target="#devismodal" data-whatever="@mdo" onclick="deviscli(<?php echo $devis['iddevis'];?>)">
              <?php foreach ($listing_service['data'] as $service) {
                if($service['idservice'] == $devis['idservice']) {
                  echo '<p><b>Nom du service : </b>' . $service['lb'] . '</p><br>';
                  echo '<p><b>Date du service : </b>' . strftime("%d/%m/%Y %H:%M", strtotime($devis['dtcrea'])) . '</p><br>';
                  echo $devis['prix'] == 0 ? '<p><b>Montant :</b> Non défini </p><br>' : '<p><b>Montant :</b> ' . $devis['prix'] . '</p></br>';
                  echo $devis['statutdevis'] == 0 ? "<p id='waiting_message_prest'>En attente de validation par le prestataire</p>" : "<p id='waiting_message_cli'>En attente de votre validation</p>";
                }
              } ?>
            </li>
    <?php
          }
        }
        else{
          echo '<h3>Aucun devis en cours</h3>';
        }
        ?>
              </ul>
            </nav>
          </div>
        </section>
      </div>
    </div>
  </div>


</div>

<div class="modal fade" id="devismodal" tabindex="-1" role="dialog" aria-labelledby="iddossier_lb" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iddossier_lb">Devis en attente de validation</h5>
                <form method="POST" action="crea_intervention.php" id="form_devis" >

                </form>
            </div>
        </div>
    </div>
</div>

<?php

  if (isset($_GET['error']) && $_GET['error'] == 'succes') {
    echo '<p>Le devis a bien été validé !</p>';
  }

  if (isset($_GET['error']) && $_GET['error'] == 'no_valide') {
    echo "<p> Le devis n'a pas encore été validé par le prestataire !";
  }

?>

<script src="rdv_service.js"></script>

<?php
  include 'footer.php';
?>

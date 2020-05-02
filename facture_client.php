<?php

include 'header.php';
include 'config.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));

$json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/facture_client?iduser=" . $_SESSION['nmuser'], false, $context);
$factures = json_decode($json, true);

if($factures != NULL){ ?>
  <div class="container">
    <div class="list-group justify-content-center">
      <div class="row d-flex justify-content-center">
        <section id="form-elegant-facture">
          <div class="card">
            <nav>
              <ul class="nav nav-pills flex-column">
            <?php foreach ($factures['data'] as $facture) {
              ?>
                <li class="list-group-item d-flex">
          <?php echo '<p>Facture du ' . strftime("%d/%m/%Y", strtotime($facture['dtdeb'])) . ' au ' . strftime("%d/%m/%Y", strtotime($facture['dtfin'])) . '</p><br>';
                echo '<p>Montant : ' . $facture['montant'] . '€</p><br>';
                echo '<form method="POST" target="_blank" action="facture/index.php">';
                echo '<input type="hidden" name="idfac  ture" value="' . $facture['idfacture'] . '">';
                echo '<input type="hidden" name="dtdebut" value="' . strftime("%Y-%m-%d", strtotime($facture['dtdeb']))   . '">';
                echo '<input type="hidden" name="dtfin" value="' . strftime("%Y-%m-%d", strtotime($facture['dtfin'])) . '">';
                echo '<input id="button_display_facture" class="btn btn-secondary" type="submit" value="Afficher facture">';
                echo '</form>';
                 ?>
               </li>
             <?php } ?>
            </ul>
          </nav>
        </div>
      </section>
    </div>
  </div>
</div>

<?php } else {
            ?>
    <p>Pas d'historique</p>
<?php
}


?>

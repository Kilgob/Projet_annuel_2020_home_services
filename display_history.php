<?php
  session_start();
  include 'config.php';

  $context = stream_context_create(array(
      'http' => array(
          'method' => "GET",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  if ($_GET['statut'] == 'all'){
    $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/historiescli?iduser=" . $_GET['iduser'], false, $context);
  }
  else {
    $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/history_by_statut?iduser=" . $_GET['iduser'] . "&statut=" . $_GET['statut'], false, $context);
  }

  $history = json_decode($json, true);

  $json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/service", false, $context);
  $list_services = json_decode($json, true);

  $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/SelectPrestataire?iduser=" . $history['data'][0]['idprestataire'], false, $context);
  $infos_prestataire = json_decode($json, true);

  $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/SelectClient?iduser=" . $history['data'][0]['iduser'], false, $context);
  $infos_client = json_decode($json, true);

?>

<div class="row d-flex justify-content-center">
    <div class="form-elegant">
        <div class="card">
            <nav>
                <ul id="display_history" class="nav nav-pills flex-column ">
                    <?php
                      if ($history != []){
                        $indice = 0;
                        echo '<div id="accordion">';
                        echo '<div class="card">';
                        foreach ($history['data'] as $intervention_infos) {
                          echo '<li class="d-flex justify-content-center">';
                          echo '<div class="nav_item_position_folders">';
                          foreach ($list_services['data'] as $service) {
                            if ($intervention_infos['idservice'] == $service['idservice']) {
                              echo '<p>' . $service['lb'] . ' (n°' . $intervention_infos['iduser'] . ') :<br>' . $intervention_infos['dtcrea'] . '</p>';
                            }
                          }
                          echo '</div></li>';
                          echo '<div class="card-header" id="heading'. $indice .'">';
                          echo '<h5 class="mb-0">';
                          echo '<button class="btn btn-link" data-toggle="collapse" data-target="#collapse'. $indice .'" aria-expanded="true" aria-controls="collapse'. $indice .'">Plus d\'informations</button>';
                          echo '</h5>';
                          echo '</div>';

                          echo '<div id="collapse'. $indice .'" class="collapse" aria-labelledby="heading'. $indice++ .'" data-parent="#accordion">';
                          echo '<div class="card-body">';
                          if ($_SESSION['cdtype_user'] == 'cli') {
                            echo '<h5>Informations du prestataire : </h5><br>';
                            echo 'Prénom : ' . $infos_prestataire['data'][0]['prenom'] . '<br>';
                            echo 'Nom : ' . $infos_prestataire['data'][0]['nom'] . '<br>';
                            echo 'Numéro : ' . $infos_prestataire['data'][0]['notel'] . '<br>';

                            echo '<form method="POST" target="_blank" action="facture/index.php">';
                            echo '<input type="hidden" value="' . $infos_client['data'][0]['iduser'] . '">';
                            echo '<input class="btn btn-secondary" type="submit" value="Afficher facture">';
                            echo '</form>';
                          }
                          else if ($_SESSION['cdtype_user'] == 'pre'){
                            echo '<h5>Informations du client : </h5><br>';
                            echo 'Prénom : ' . $infos_client['data'][0]['prenom'] . '<br>';
                            echo 'Nom : ' . $infos_client['data'][0]['nom'] . '<br>';
                            echo 'Numéro : ' . $infos_client['data'][0]['notel'] . '<br>';
                          }
                          else {
                            echo '<h5>Informations du client : </h5><br>';
                            echo 'Prénom : ' . $infos_client['data'][0]['prenom'] . '<br>';
                            echo 'Nom : ' . $infos_client['data'][0]['nom'] . '<br>';
                            echo 'Numéro : ' . $infos_client['data'][0]['notel'] . '<br><br>';

                            echo '<h5>Informations du prestataire : </h5><br>';
                            echo 'Prénom : ' . $infos_prestataire['data'][0]['prenom'] . '<br>';
                            echo 'Nom : ' . $infos_prestataire['data'][0]['nom'] . '<br>';
                            echo 'Numéro : ' . $infos_prestataire['data'][0]['notel'] . '<br><br>';

                            echo '<form method="POST" target="_blank" action="facture/index.php">';
                            echo '<input type="hidden" name="iduser" value="' . $infos_client['data'][0]['iduser'] . '">';
                            echo '<input class="btn btn-secondary" type="submit" value="Afficher facture">';
                            echo '</form>';
                          }

                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                        }
                      echo '</div>';
                      echo '</div>';
                    }
                    else {
                      echo "<p>Rien à afficher !</p>";
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

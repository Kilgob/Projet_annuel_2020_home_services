<?php
  session_start();
  include 'config.php';

  $context = stream_context_create(array(
      'http' => array(
          'method' => "GET",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  if ($_GET['statut'] == 'all'){
    $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/histories?iduser=" . $_GET['iduser'], false, $context);
  }
  else {
    $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/history_by_statut?iduser=" . $_GET['iduser'] . "&statut=" . $_GET['statut'], false, $context);
  }

  $history = json_decode($json, true);

  $json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/service", false, $context);
  $list_services = json_decode($json, true);

?>

<div class="row d-flex justify-content-center">
    <div class="form-elegant">
        <div class="card">
            <nav>
                <ul id="display_history" class="nav nav-pills flex-column ">
                    <?php
                      if ($history != []){
                        foreach ($history['data'] as $intervention_infos) {
                          echo '<li class="d-flex justify-content-center">';
                          echo '<div class="nav_item_position_folders">';
                          foreach ($list_services['data'] as $service) {
                            if ($intervention_infos['idservice'] == $service['idservice']) {
                              echo '<p>' . $service['lb'] . ' (n°' . $intervention_infos['iduser'] . ') :<br>' . $intervention_infos['dtcrea'] . '</p>';
                            }
                          }
                          echo '</div></li>';
                        }
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

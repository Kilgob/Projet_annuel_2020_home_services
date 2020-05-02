<?php


include_once("./lang.php");
include 'config.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

$json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence_get_ip?idagence=" . $_GET['idagence'], false, $context);
$infoAgence=json_decode($json, true);


?>


    <div class="form-elegant-gestion">
        <div class="card">
            <nav>
                <ul id="display_users" class="nav nav-pills flex-column ">

                    <?php
                    $name = $_GET['type_user']== 1 ?"Prestataire":"Client";
                    switch($_GET['type_user']){
                        case '1':
                        case '2':
                          if ($infoAgence['data'][0]['ip'] != null) {
                            $type_user = $_GET['type_user'] == 1 ? 'pre' : 'cli';
                            $requete = "http://" . $infoAgence['data'][0]['ip'] . ":" . $infoAgence['data'][0]['port'] . "/gestion_user?type_user=" . $type_user;
                            $json = file_get_contents($requete, false, $context);
                            $liste_prestataire = json_decode($json, true);

                            if ($liste_prestataire != []) {
                              foreach ($liste_prestataire['data'] as $folder) {
                                  if ($folder['okactif'] != "0") {
                                      echo '<li  onclick="research(' . $folder['iduser'] . ')" class="d-flex justify-content-center">';
                                      echo '<div class="nav_item_position_folders">';
                                      echo '<p>' . $name . ' (n°' . $folder['iduser'] . ') :<br>' . $folder['mail'] . '</p>';
                                      echo '</div></li>';
                                  }
                                  else {
                                      echo '<li  onclick="research(' . $folder['iduser'] . ')" class="d-flex justify-content-center,nav-item_en_cours">';
                                      echo '<div id="en_cours" class="nav_item_position_folders_yellow">';
                                      echo '<p>' . $name . ' (n°' . $folder['iduser'] . ') :<br>' . $folder['mail'] . '<br>(En attente de validation)</p>';
                                      echo '</div></li>';
                                  }
                              }
                            }
                            else {
                              echo 'Aucun prestataire à afficher !';
                            }
                          }
                          else {
                            echo 'L\'agence n\'a pas encore été configurée !';
                          }


                            break;
                        case '3':
                            $requete = "http://" . $GLOBALS['IP_SIEGE'] . "/categ_from_agence?agence=" . $_GET['idagence'];
                            $json = file_get_contents($requete, false, $context);
                            $listeCategService = json_decode($json, true);
                            foreach ($listeCategService['data'] as $folder) {
                                if ($folder['statut'] != "0") {
                                    echo '<li id=' . $folder['idcategservice'] . '  onclick="researchS(' . $folder['idcategservice'] . ')" class="d-flex justify-content-center">';
                                    echo '<div class="nav_item_position_folders">';
                                    echo '<p>catégorie (n°' . $folder['idcategservice'] . ') :<br>' . $folder['lb'] . '</p>';
                                    echo '</div></li>';
                                }
                                else {
                                    echo '<li class="nav-item_en_cours">';
                                    echo '<div id="en_cours" class="nav_item_position_folders_yellow">';
                                    echo '<p>catégorie (n°' . $folder['idcategservice'] . ') :<br>' . $folder['lb'] . '<br>(En attente de validation)</p>';
                                    echo '</div></li>';
                                }
                            }
                            break;
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>

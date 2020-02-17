<?php
    include 'header.php';
    include 'config.php';

    if($_SESSION['cdtype_user'] == 'cli' && $_SESSION['cdtype_user'] == 'pre'){
    header('Location: homePage.php');
    exit;
    }

    $context = stream_context_create(array(
        'http' => array(
            'method' => "GET",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    //if(isset( $_POST['service']) && isset($_POST['price']) && isset($_POST['agence_selected']) && isset($_POST['categService']))

    $requete = "http://" . $_SESSION['ip_agence'] . "/prestataire";
    $json = file_get_contents($requete, false, $context);
    $liste_prestataire=json_decode($json, true);

 ?>

<main>


    <section class="container-fluid container_fluid_homePage">
      <div class="row d-flex justify-content-center">
        <div class="col-md-2 col_homePage">
          <div class="row d-flex justify-content-center title_my_row">
            <h3>Mes dossiers</h3>
          </div>

          <div class="row d-flex justify-content-center">
            <div class="form-elegant" >
              <div class="card">
                <nav>
                  <ul id="display_users" class="nav nav-pills flex-column ">

                    <?php

                      foreach($liste_prestataire['data'] as $folder){

                        if($folder['okactif'] != "0"){
                          echo '<li  onclick="research(' . $folder['iduser'] . ')" class="d-flex justify-content-center">';
                          echo '<div class="nav_item_position_folders">';
                          echo '<p>Prestataire ' . $folder['iduser'] . ' :<br>' . $folder['mail'] . '</p>';
                          echo '</div></li>';
                        }
                        else{
                          echo '<li class="nav-item_en_cours">';
                          echo '<div id="en_cours" class="nav_item_position_folders_yellow">';
                          echo '<p>Prestataire ' . $folder['iduser'] . ' :<br>' . $folder['mail'] . '<br>(En attente de validation)</p>';
                          echo '</div></li>';
                        }
                      }
                    ?>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>


        <div id="section1" class="col-md-5 col_homePage"> <!--le dossier-->
          <!-- <div id="section1" class="dossier"> -->
            <h3 class="row d-flex justify-content-center title_my_row">Choisissez un dossier</h3>

          </div>
        </div>
      </div>
    </section>

    <section id='end'> <!--pour placer le footer correctement-->
      <!-- <input type="button" onclick="mafonction()"/>
      gdqsgqgfqgiu -->
    </section>
    <script src="prestataire.js"> </script>
    <script type="text/javascript" src="checkCategAndService.js"></script>
  </main>


  <?php include 'footer.php'; ?>

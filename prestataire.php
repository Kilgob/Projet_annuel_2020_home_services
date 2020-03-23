<?php
    include_once("./lang.php");
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

    $requete = "http://" . $_SESSION['ip_agence'] . "/gestion_user?type_user=pre";
    $json = file_get_contents($requete, false, $context);
    $liste_prestataire=json_decode($json, true);

    $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence", false, $context);
    $listeAgence=json_decode($json, true);


 ?>

<main>


    <section class="container-fluid container_fluid_homePage">
      <div class="row d-flex justify-content-center">
        <div class="col-md-2 col_homePage">
          <div class="row d-flex justify-content-center title_my_row">

              <div class="row d-flex justify-content-center title_my_row">
                  <!-- <p>Choisissez votre agence</p> -->
                  <select onchange="showUserList()" name="agence_selected" id="agence_select">
                      <option value="default" selected><?= t("Sélectionnez une agence") ?></option>
                      <?php foreach ($listeAgence['data'] as $result) {
                          //$result_terner = $result['idagence'] == 4?'selected':' ' ;//Sélectionner l'agence choisit
                          echo '<option value="' . $result['idagence'] . '">' . $result['nom'] . " (" . $result['ville'] . ')</option>';
                      }
                      ?>
                  </select>
              </div>

              <div class="row d-flex justify-content-center title_my_row" id="type_user_list">
                  <!-- <p>Choisissez quoi lister</p> -->
                  <!-- <select onchange="finPrest()" name="type_user" id="type_user">
                    <option value="default" selected>Faites un choix</option>
                    <option value="1">Prestataire</option>
                    <option value="2">Client</option>
                    <option value="3">Service</option>
                  </select> -->
              </div>

            <h3 id="title_list"><?= t("Veuillez sélectionner une agence puis un type d'utilisateur") ?></h3>
          </div>


          <div id="new_prest" class="row d-flex justify-content-center">

          </div>
        </div>


          <div id="section1" class="col-md-5 col_homePage"> <!--le dossier-->
          <!-- <div id="section1" class="dossier"> -->
            <!-- <h3 class="row d-flex justify-content-center title_my_row">Choisissez un dossier</h3> -->
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
    <script src="history.js"></script>
  </main>


  <?php include 'footer.php'; ?>

<?php
    include_once("./lang.php");
    include 'config.php';


    $id = $_GET['folder'];
    // $id = 'clem@outlook.com';

    $context = stream_context_create(array(
      'http' => array(
          'method' => "GET",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence", false, $context);
    $listeAgence=json_decode($json, true);

    $requete = "http://" . $GLOBALS['IP_SIEGE'] . "/unique_categ_service?idcatserv=" . $_GET['folder'] ;
    $json = file_get_contents($requete, false, $context);
    $liste_categ_service = json_decode($json, true);

    $requete = "http://" . $GLOBALS['IP_SIEGE'] . "/select_service_from_categ?idcatservice=" . $_GET['folder'] ;
    $json = file_get_contents($requete, false, $context);
    $liste_service = json_decode($json, true);

//    $gender = $userInfo['gender'] == 1 ? "Monsieur" : "Madame";

    echo '<div class="row d-flex justify-content-center title_my_row">';
    echo '<p id=title_folder><h3>' . $liste_categ_service['data'][0]['lb'] . '</h3></p>';
    echo '</div>';

    echo '<div id="scroll_folder" class="form-elegant" >';
    echo '<div id=under_srcoll>';
    echo '<div></div>';
    echo '<div class="form-group">';
    echo '<i id="size_date">Date de la création de cette catégorie : ' . substr($liste_categ_service['data'][0]['dtcrea'],0, -9) . '</i>';
    echo '<br><i id="size_date">Date de la dernière modification de cette catégorie : ' . substr($liste_categ_service['data'][0]['dtmaj'],0, -9) . '</i>';
    echo '</div>';
    echo '<div></div>';

    ?>
<section class="row d-flex justify-content-center">
  <div class="col-md-5 d-flex justify-content-center">
    <div id="user_profil_form">
      <form method="POST" action="edit_categ_service_back.php">
        <div class="d-flex justify-content-center">
          <div class="form-group row user_profil_input_row">
            <div class="mx-auto user_profil_align">

                <div class="form-group">
                    nom : <input type='text' class="form-control" placeholder="Prénom" aria-label="firstname" aria-describedby="basic-addon1" value="<?php echo $liste_categ_service['data'][0]['lb']; ?>" name="lb" />
                </div>
                <div class="form-group">
                    <br><i>Statut : </i>
                    <br><input type="radio" id="statutac" name="okactif" value="1" <?php echo $liste_categ_service['data'][0]['statut'] == 1?'Checked':' '; ?> > Catégorie de service activé</input>
                    <br><input type="radio" id="statutdesac" name="okactif" value="0"<?php echo $liste_categ_service['data'][0]['statut'] == 0?'Checked':' '; ?> > Catégorie de service désactivé</input>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control input_247px" aria-label="idcateg" aria-describedby="basic-addon1" value="<?php echo $liste_categ_service['data'][0]['idcategservice']; ?>" name="idcateg" />
                </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <b>réattribuer la catégorie à une agence</b>
          <select onchange="finAgence()" name="agence_selected" id="agence_select_service">
            <?php foreach ($listeAgence['data'] as $result) {
              $result_terner = $result['idagence'] == 4?'selected':' ' ;//Sélectionner l'agence choisit
              echo '<option value="' . $result['idagence'] . '"' . $result_terner . '>' . $result['nom'] . " (" . $result['ville'] . ')</option>';
            }
            ?>

          </select>
        </div>
          <div>
              <input class="btn btn-secondary" type='submit' value="Modifier les informations de la catégorie" />
          </div>
        </div>


    </form>
  </div>
</section>

  <?php

    echo '</div>';
    echo '<div class="form-group">';
    ?>
    <div class="row d-flex justify-content-center">
        <p>Sélectionner un service de cette catégorie pour le voir en détail : </p>
        <select onchange="searchservice()" name="type_user" id="select_service">
            <?php
            foreach ($liste_service['data'] as $categService) { ?>
                <option value="<?php echo $categService['idservice']; ?>"><?php echo $categService['lb']; ?></option>
                <?php
            }
            echo '<option value="" selected>-- Sélectionner un service --</option>';
    echo'</select></div>';
    ?>
            <div id="info_service" class="d-flex justify-content-center">
            </div>
    <?php
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';



?>

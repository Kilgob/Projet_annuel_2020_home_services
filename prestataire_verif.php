<?php
  session_start();
  include 'config.php';


  $id = $_GET['folder'];
  // $id = 'clem@outlook.com';

  $context = stream_context_create(array(
      'http' => array(
          'method' => "GET",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  //if(isset( $_POST['service']) && isset($_POST['price']) && isset($_POST['agence_selected']) && isset($_POST['categService']))

  $requete = "http://" . $_SESSION['ip_agence'] . "/SelectPrestataire?iduser=" . $id;
  $json = file_get_contents($requete, false, $context);
  $userInfo=json_decode($json, true);

  $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence", false, $context);
  $listeAgence=json_decode($json, true);

//    $gender = $userInfo['gender'] == 1 ? "Monsieur" : "Madame";

    echo '<div class="row d-flex justify-content-center title_my_row">';
    echo '<p id=title_folder><h3>' . $userInfo['data'][0]['nom'] . '</h3></p>';
    echo '<h5><span class="badge badge-dark">' . $userInfo['data'][0]['cdtype_user'] . '</span></h5>';
    echo '</div>';

    echo '<div id="scroll_folder" class="form-elegant" >';
    echo '<div id=under_srcoll>';
    echo '<div></div>';
    echo '<div class="form-group">';
    echo '<i id="size_date">Date de création du compte : ' . substr($userInfo['data'][0]['dtcrea'],0, -9) . '</i>';
    echo '<br><i>Statut : ' . $userInfo['data'][0]['okactif'] . '</i>';
    echo '</div>';
    echo '<div></div>';

    ?>
<section class="row d-flex justify-content-center">
  <div class="col-md-5 d-flex justify-content-center">
    <div id="user_profil_form">
      <form method="POST" action="edit_prestataire_back.php">
        <div class="d-flex justify-content-center">
          <div class="form-group row user_profil_input_row">
            <div class="mx-auto user_profil_align">

              <div class="form-group display_input_inline_block">
                <input type='text' class="form-control" placeholder="Prénom" aria-label="firstname" aria-describedby="basic-addon1" value="<?php echo $userInfo['data'][0]['prenom']; ?>" name="prenom" />
                <input type='text' class="form-control" placeholder="Nom" aria-label="lastname" aria-describedby="basic-addon1" value="<?php echo $userInfo['data'][0]['nom']; ?>" name="nom" />
              </div>
              <div class="form-group">
                <input type='text' class="form-control" placeholder="Email" aria-label="email" aria-describedby="basic-addon1" value="<?php echo $userInfo['data'][0]['mail']; ?>" size="30" name="mail" />
              </div>
              <div id="user_profil_address_and_num_div" class="form-group">
                <input id="user_profil_address_input" type="text" class="form-control" placeholder="Adresse" aria-label="address" aria-describedby="basic-addon1" value="<?php echo $userInfo['data'][0]['adresse']; ?>" name="adresse" />
              </div>
              <div class="form-group">
                <input type="text" class="form-control input_247px" placeholder="Ville" aria-label="town" aria-describedby="basic-addon1" value="<?php echo $userInfo['data'][0]['ville']; ?>" name="ville" />
              </div>
              <div class="form-group">
                <input type="text" class="form-control input_247px" placeholder="Numéro de téléphone" aria-label="num_tel" aria-describedby="basic-addon1" value="<?php echo $userInfo['data'][0]['notel']; ?>" name="notel" />
              </div>
              <i>Ajouter de quoi changer le mdp</i>
            </div>
          </div>
        </div>
        <div class="form-group">
          <b>réattribuer le prestataire à une agence</b>
          <select onchange="finAgence()" name="agence_selected" id="agence_select_service">
            <?php foreach ($listeAgence['data'] as $result) {
              $result_terner = $result['idagence'] == 4?'selected':' ' ;//Sélectionner l'agence choisit
              echo '<option value="' . $result['idagence'] . '"' . $result_terner . '>' . $result['nom'] . " (" . $result['ville'] . ')</option>';
            }
            ?>

<!--            <option value="" selected>--Réassigner à une agence--</option>-->
          </select>
        </div>
        <div class="form-group">
          <select name="categService" id="categ_service_updt">
            <option value="" selected>--Selectionnez d'abord une agence--</option>
          </select>
        </div>
        <input class="btn btn-secondary" type='submit' value="Modifier les informations du prestataire" />
    </div>
    </form>
  </div>
</section>

  <?php
//    $file_pj_request = $bdd->prepare("SELECT nmrep,nmfic,nmfic_checksum,nmuserfic FROM tabpj,dossiers WHERE dossiers.iddossier = tabpj.iddossier AND dossiers.iddossier = ?");
//    $file_pj_request->execute(array($id));
//
//    echo '<div class="form-group">';
//    echo '<h5>Les pièces jointes liées au dossier : </h5>';
//
//    $j = 1;
//    while($file_pj = $file_pj_request->fetch()){
//      header("Content-Type: application/force-download");
//      header("Content-Type: application/octet-stream");
//      header("Content-Type: application/download");
//      echo '<div><a id="' . $file_pj['nmfic'] . '" href="' . $file_pj['nmrep'].$file_pj['nmfic'] . ' " download="' . $file_pj['nmuserfic'] . '">' . $file_pj['nmuserfic'] . '</a> <input class="btn btn-secondary" type="button" id="' . $file_pj['nmfic'] . '_button" value="Suppression du fichier" onclick="delete_file(\'' .  $file_pj['nmfic'] . '\')" /><div></div><div>';
//    }
    echo '</div>';
    echo '<div class="form-group">';
    echo '<p>Envoyer un fichier : '; include 'envoi_file.php';
    echo '</div>';
    echo '</div>';
    echo '</div>';



?>

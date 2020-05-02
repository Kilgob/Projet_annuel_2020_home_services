<?php
include_once("./lang.php");
  include 'header.php';
  include 'config.php';

    $context = stream_context_create(array(
        'http' => array(
            'method' => "GET",
            'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
    ));

    $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence", false, $context);
    $listeAgence=json_decode($json, true);
?>
<main>
    <section id="page_content_connexion" class="d-flex justify-content-center">
      <section id="connexion_form">
        <form method="POST" action="Connexion.php">
          <h3 id="connexion_title"><?= t("Connexion") ?></h3>
          <div id="connexion_input_row" class="form-group row">
            <div class="col-xs-2">
              <!-- <label><?= t("Email") ?></label><div></div> -->
              <input type="text" class="form-control connexion_input" placeholder="Identifiant" aria-label="Username" aria-describedby="basic-addon1" name="username"><div class="space"></div>
            </div>
            <div class="col-xs-2">
              <!-- <label><?= t("Mot de passe") ?></label><div></div> -->
              <input type="password" class="form-control connexion_input" placeholder="Mot de passe" aria-label="Username" aria-describedby="basic-addon1" name="password"><div class="space"></div>
            </div>
            <div class="form-group col-xs-3">
                <select class="form-control" name="agence_selected" id="agence-select_agence">
                    <?php foreach ($listeAgence['data'] as $result) {
                        echo '<option value="' . $result['idagence'] . '">' . $result['nom'] . " (" . $result['ville'] . ')</option>';
                    } ?>

                    <option value="" selected><?= t("Sélectionner une agence") ?>--</option>
                </select>
            </div>
          </div>
          <input type="submit" class="btn btn-primary" value="Connexion"/>
        </form>
        <!-- <div class="space"></div>
        <a href="inscription.php"><button type="button" class="btn btn-secondary btn-sm"><?= t("Inscription") ?></button></a>
        <button data-toggle="modal" data-target="#forgotten_password_modal" data-whatever="@mdo" type="button" class="btn btn-secondary btn-sm"><?= t("Mot de passe oublié") ?></button></a>
      </section> -->
    </section>

    <div class="modal fade" id="forgotten_password_modal" tabindex="-1" role="dialog" aria-labelledby="password" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?= t("Veuillez saisir votre identifiant / email") ?></h5>

          </div>
          <form method="POST" action="password_forgotten_verification.php">
            <div class="modal-body" id="mail_input">
                <input type="text" class="form-control" placeholder="Identifiant" aria-label="Email" aria-describedby="basic-addon1" name="login" />
            </div>
            <div id="bouton_suppr" class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t("Fermer") ?></button>
              <button type="submit" class="btn btn-primary"><?= t("Envoyer") ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>

</main>

<?php
  if(isset($_GET['error']) && $_GET['error'] == 'account_missing'){
    echo '<p class="p_display_error">Identifiant/Mot de passe incorrect !</p>';
  }

  if(isset($_GET['error']) && $_GET['error'] == 'disabled'){
    echo '<p class="p_display_error">Votre compte n\'est pas activé !</p>';
  }

  if(isset($_GET['msg']) && $_GET['msg'] == 'disconnect'){
    echo '<p class="p_display_error">Vous êtes déconnecté !</p>';
  }

  if(isset($_GET['error']) && $_GET['error'] == 'email_format'){
    echo '<p class="p_display_error">Veuillez renseigner un email valide !</p>';
  }

  if(isset($_GET['error']) && $_GET['error'] == 'email_missing'){
    echo '<p class="p_display_error">Veuillez renseigner une adresse mail</p>';
  }

  if(isset($_GET['msg']) && $_GET['msg'] == 'succes_email_password'){
    echo '<p class="p_display_error">Un email vous a été envoyé pour changer votre mot de passe !</p>';
  }

  if(isset($_GET['error']) && $_GET['error'] == 'login_dont_exist'){
    echo '<p class="p_display_error">L\'email n\'exite pas ! Si vous n\'avez pas de compte, veuillez vous incrire.</p>';
  }

if(isset($_GET['error']) && $_GET['error'] == 'no_agence_selected'){
    echo '<p class="p_display_error">Vous n\'avez pas sélectionné d\'agence !</p>';
}

  include 'footer.php';
?>

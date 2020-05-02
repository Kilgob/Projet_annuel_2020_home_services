<?php
  include_once("./lang.php");
include 'config.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

$requete = "http://" . $GLOBALS['IP_SIEGE'] . "/unique_service?service=" . $_GET['folder'];
    $json = file_get_contents($requete, false, $context);
    $liste_service = json_decode($json, true);

?>

<form method="POST" action="edit_service_back.php">
    <div class="d-flex justify-content-center">
        <div class="form-group row user_profil_input_row">
            <div class="mx-auto user_profil_align">

                <div class="form-group">
                    nom : <input type='text' class="form-control" placeholder="Prénom" aria-label="label" aria-describedby="basic-addon1" value="<?php echo $liste_service['data'][0]['lb']; ?>" name="lb" />
                </div>
                <div class="form-group">
                    nom : <input type='text' class="form-control" placeholder="prix" aria-label="price" aria-describedby="basic-addon1" value="<?php echo $liste_service['data'][0]['prix']; ?>" name="price" />
                </div>
                <div class="form-group">
                    <br><i>Statut : </i>
                    <br><input type="radio" id="statutac" name="okactif" value="1" <?php echo $liste_service['data'][0]['statut'] == 1?'Checked':' '; ?> > Service activé</input>
                    <br><input type="radio" id="statutdesac" name="okactif" value="0"<?php echo $liste_service['data'][0]['statut'] == 0?'Checked':' '; ?> > Service désactivé</input>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control input_247px" aria-label="iduser" aria-describedby="basic-addon1" value="<?php echo $liste_service['data'][0]['idservice']; ?>" name="idservice" />
                </div>
                <div>
                    <input class="btn btn-secondary" type='submit' value="Modifier les informations du service" />
                </div>
            </div>
        </div>
    </div>
</form>

<?php
include 'config.php';
include_once 'header.php';


$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

//if(isset( $_POST['service']) && isset($_POST['price']) && isset($_POST['agence_selected']) && isset($_POST['categService']))

$requete = "http://" . $_SESSION['ip_agence'] . "/SelectPrestataire?iduser=" . $_SESSION['nmuser'];
$json = file_get_contents($requete, false, $context);
$userInfo=json_decode($json, true);

$json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence", false, $context);
$listeAgence=json_decode($json, true);

$json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/abonnement", false, $context);
$listeAbonnement=json_decode($json, true);


function getNameAbonnement($id)
{
    $context = stream_context_create(array(
        'http' => array(
            'method' => "GET",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    $requete = "http://" . $GLOBALS['IP_SIEGE'] . "/unique_abonnement?idabo=" . $id;
    $json = file_get_contents($requete, false, $context);
    $abonnement = json_decode($json, true);

    //Vérification si il y a un nom pour le service sélectionné
    if ($abonnement != '' || $abonnement != 0){
        return $abonnement['data'][0]['lb'] . ' (' . $abonnement['data'][0]['prix'] . '€)';
    }
    return '<i>Pas d\'abonnement</i>';
}


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
                            <div>
                                <br><i>Statut : </i>
                                <br><input type="radio" id="statutac" name="okactif" value="1" <?php echo $userInfo['data'][0]['okactif'] == 1?'Checked':' '; ?> > Compte activé</input>
                                <br><input type="radio" id="statutdesac" name="okactif" value="0"<?php echo $userInfo['data'][0]['okactif'] == 0?'Checked':' '; ?> > Compte désactivé</input>
                            </div>
                            <i>Ajouter de quoi changer le mdp</i>
                            <div class="form-group">
                                <input type="hidden" class="form-control input_247px" aria-label="iduser" aria-describedby="basic-addon1" value="<?php echo $userInfo['data'][0]['iduser']; ?>" name="iduser" />
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <p>Mon abonnement : <?php echo getNameAbonnement($userInfo['data'][0]['idabonnement']);  ?></p>
                </div>

                <input class="btn btn-secondary" type='submit' value="Modifier les informations" />
                <input class="btn btn-secondary" data-toggle="modal" data-target="#historyModal" data-whatever="@mdo" onclick="findHistory(<?php echo $userInfo['data'][0]['iduser'];?>)" value="Afficher l'historique"/>
                <?php
                if($userInfo['data'][0]['idabonnement'] != 0){
                    echo '<input class="btn btn-secondary" data-toggle="modal" data-target="#confirmDeleteAbo" data-whatever="@mdo" value="supprimer l\'abonnement"/>';
                }
                else{
                    echo '<input class="btn btn-secondary" data-toggle="modal" data-target="#newAbo" data-whatever="@mdo" value="demander un abonnement"/>';
                }
                ?>

        </div>
        </form>
    </div>
</section>
<?php
include_once 'footer.php';
?>
<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="iddossier_lb" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iddossier_lb">Historique des interventions</h5>
                <form id="interventions_statut" onchange="findHistory(<?php echo $userInfo['data'][0]['iduser'];?>)">
                    <input type="radio" id="statutAll" name="statut" value="all" checked>
                    <label for="statutAll">Tout</label>
                    <input type="radio" id="statut0" name="statut" value="0">
                    <label for="statut0">En attente</label>
                    <input type="radio" id="statut1" name="statut" value="1">
                    <label for="statut1">En cours</label>
                    <input type="radio" id="statut2" name="statut" value="2">
                    <label for="statut2">Terminé</label>
                </form>
            </div>
            <div class="modal-body" id="history">
                <!-- Display history -->
            </div>
        </div>
    </div>
</div>

<!-- block suppression abonnement -->
<div class="modal fade" id="confirmDeleteAbo" tabindex="-1" role="dialog" aria-labelledby="iddossier_lb" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iddossier_lb">Confirmer la suppression de l'abonnement ?</h5>
                <form method="POST" action="delete_abonnement.php">
                    <input  type='hidden' name="delete_abo" value="<?php echo $userInfo['data'][0]['iduser']; ?>" />
                    <input class="btn btn-secondary" type='submit' value="Valider" />
                </form>
            </div>
            <div class="modal-body" id="history">
                <!-- Display history -->
            </div>
        </div>
    </div>
</div>
<!-- block nouvel abonnement -->
<div class="modal fade" id="newAbo" tabindex="-1" role="dialog" aria-labelledby="iddossier_lb" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <h5 class="modal-title" id="iddossier_lb">Nouvel abonnement ?</h5>
            <div class="modal-header">

                <form method="POST" action="edit_abonnement.php">
                    <input  type='hidden' name="iduser" value="<?php echo $_SESSION['nmuser']; ?>" />

                    <select  name="abo_selected">
                        <?php
                        foreach ($listeAbonnement['data'] as $listeAbo){
                            echo '<option value="' . $listeAbo['idabonnement'] . '">' . $listeAbo['lb'] . '</option>';
                        }
                        ?>
                    </select>
                    <input class="btn btn-secondary" type='submit' value="Valider" />
                </form>
            </div>
            <div class="modal-body" id="history">
                <!-- Display history -->
            </div>
        </div>
    </div>
</div>

<script src="history.js"></script>

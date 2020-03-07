<?php
session_start();
include 'config.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));
$json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence", false, $context);
$listeAgence=json_decode($json, true);

$requete = "http://" . $GLOBALS['IP_SIEGE'] . "/unique_abonnement?idabo=" . $_GET['folder'];
$json = file_get_contents($requete, false, $context);
$liste_service = json_decode($json, true);

?>

<form method="POST" action="edit_abonnement_back.php">
    <div class="d-flex justify-content-center">
        <div class="form-group row user_profil_input_row">
            <div class="mx-auto user_profil_align">

                <div class="form-group">
                    nom : <input type='text' class="form-control" placeholder="nom de l'abonnement" aria-label="label" aria-describedby="basic-addon1" value="<?php echo $liste_service['data'][0]['lb']; ?>" name="lb" />
                </div>
                <div class="form-group">
                    prix : <input type='text' class="form-control" placeholder="prix" aria-label="price" aria-describedby="basic-addon1" value="<?php echo $liste_service['data'][0]['prix']; ?>" name="price" />
                </div>
                <div class="form-group">
                    description : <input type='text' class="form-control" placeholder="description" aria-label="description" aria-describedby="basic-addon1" value="<?php echo $liste_service['data'][0]['description']; ?>" name="description" />
                </div>
                <div class="form-group">
                    Nombre de jour disponible : <input type='text' class="form-control" placeholder="nombre d ejour disponible par semaine" aria-label="nbrdispo_days" aria-describedby="basic-addon1" value="<?php echo $liste_service['data'][0]['nbrdispojour']; ?>" name="nbrdispo_days" />
                </div>
                <div class="form-group">
                    horaire de début : <input type='text' class="form-control" placeholder="horaire debut" aria-label="hr_start" aria-describedby="basic-addon1" value="<?php echo $liste_service['data'][0]['horairedebut']; ?>" name="hr_start" />
                </div>
                <div class="form-group">
                    horaire de fin : <input type='text' class="form-control" placeholder="horaire fin" aria-label="hr_end" aria-describedby="basic-addon1" value="<?php echo $liste_service['data'][0]['horairefin']; ?>" name="hr_end" />
                </div>
                <div class="form-group">
                    Cycle d'abonnemnt : <input type='text' class="form-control" placeholder="cycleabo" aria-label="cycleabo" aria-describedby="basic-addon1" value="<?php echo $liste_service['data'][0]['cycleabo']; ?>" name="nbr_days_abos" />
                </div>
                <div class="form-group">
                    <input type="hidden" value="<?php echo $liste_service['data'][0]['idservice']; ?>" name="idservice" />
                </div>
                <input type='hidden' value="<?php echo $liste_service['data'][0]['idabonnement']; ?>" name="idabonnement" />
                <div class="form-group">
                    <p>réattribuer l'abonnement à une agence</p>
                    <select onchange="finAgence()" name="agence_selected" id="agence_select_service">
                        <?php foreach ($listeAgence['data'] as $result) {
                            $result_terner = $result['idagence'] == 4?'selected':' ' ;//Sélectionner l'agence choisit
                            echo '<option value="' . $result['idagence'] . '"' . $result_terner . '>' . $result['nom'] . " (" . $result['ville'] . ')</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <input class="btn btn-secondary" type='submit' value="Modifier les informations de l'abonnement" />
                </div>
            </div>
        </div>
    </div>
</form>

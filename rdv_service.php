<?php
  include_once("./lang.php");
include 'header.php';
include_once 'config.php';
include_once  "calendar/calendar.php";

require_once 'VerificationAbonnement.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

$requete = "http://" . $GLOBALS['IP_SIEGE'] . "/categ_from_agence?agence=" . $_SESSION['id_agence'];
$json = file_get_contents($requete, false, $context);
$categ = json_decode($json, true);

$json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/SelectClient?iduser=" . $_SESSION['nmuser'], false, $context);
$user_infos = json_decode($json, true);

// Vérification du statut de l'abonnement
// if ($user_infos['data'][0]['statutabo'] == 1 && $_SESSION['idTabAbonnement'] != NULL) {
//   $user_abonnement = new VerificationAbonnement($_SESSION['idTabAbonnement'], $_SESSION['nmuser']);
//
//   if ($user_abonnement->checkEndDate() == true) {
//     $_SESSION['idTabAbonnement'] = NULL;
//     $user_abonnement->updateStatut();
//     $user_abonnement->calculPrix();
//     $user_abonnement->generateFacture();
//
//   }
// }
//
// if ($_SESSION['idTabAbonnement'] == NULL) {
//   header('Location: index.php');
//   exit;
// }
//
//   echo $_SESSION['idTabAbonnement'];


?>
 <div class="ml-4"><strong><?= t("Création service")?></strong></div>

 <form class="row container mx-auto mt-4" method="post" action="create_devis.php">
     <input type="text" id="date" name="date" hidden />
     <div class="col-8">
         <p><ins><?= t("Choisissez une catégorie de services")?></ins></p>
         <?php
         echo '<select onchange="researchService()" name="categService" id="categ_service_updt">';
         foreach ($categ['data'] as $result) {
             if($result["statut"] == 1) {
                 echo '<option value="' . $result['idcategservice'] . '">' . $result['lb'] . '</option>';
             }
         }
         ?>
            <option value="" selected>--<?= t("Choisissez une catégorie de service")?>--</option>
         </select>
    </div>
    <p class=""><ins><?= t("Choisissez un service puis definissez un rendez vous")?></ins></p>


    <div class="col-8" id="section_service">
    </div>
     <div class="col-8">
         <input type="text" placeholder="Description" name="description"></div>
     </div>

    <div class="col-4" id="calendar">
        <h3><?= t("Choisir une date")?></h3>
        <div class="row">
            <div class="col-12 mt-3">
                <p><?= t("Choisir une date pour votre service")?></p>
                <select name="clock">
                    <?php for($i = 0 ; $i < 24; $i++){
                        echo '<option value="'. $i . ':00">' . $i . ':00</option>';
                    }?>

                </select>
            </div>
                <input type="submit" class="btn btn-primary w-100" value="Suivant">
        </div>
    </div>
</form>

<script type="text/javascript" src="rdv.js"></script>

<?php
include 'footer.php';
?>

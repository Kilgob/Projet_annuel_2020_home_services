<?php
  include_once("./lang.php");
include_once  'config.php';
include_once 'header.php';
include_once  "calendar/calendar.php";
//include_once  "calendar/calendar.php";

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));
$requete = "http://" . $GLOBALS['IP_SIEGE'] . "/categ_from_agence?agence=" . $_SESSION['id_agence'];
$json = file_get_contents($requete, false, $context);
$categ = json_decode($json, true);


?>
 <div class="ml-4"><strong><?= t("Création service")?></strong></div>

 <form class="row container mx-auto mt-4" method="get" action="rdv_new_intervention_back.php">
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

    <div class="col-4" id="calendar">
        <h3><?= t("Choisir une date")?></h3>
        <div class="row">
            <div class="col-12 mt-3">
                <p><?= t("Choisir une date pour votre service")?></p>
                <select name="clock">
                    <?php for($i = 0 ; $i < 25; $i++){
                        echo '<option value="'. $i . ':00">' . $i . ':00</option>';
                    }?>

                </select>
            </div>
                <button class="btn btn-primary w-100" ><?= t("Suivant")?></button>

        </div>
    </div>
</form>

<script type="text/javascript" src="rdv.js"></script>

<?php
include 'footer.php';
?>

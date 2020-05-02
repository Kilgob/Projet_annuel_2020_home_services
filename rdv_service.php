<?php
  include_once("./lang.php");
include 'header.php';
include_once 'config.php';
include_once  "calendar/calendar.php";

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


?>
<section class="container_fluid container_fluid_homePage">
  <div class="row d-flex justify-content-center">
    <div class="col-md-4 col_service">
      <div class="row d-flex justify-content-center title_my_row">
        <h3> Prise de service </h3>
      </div>
       <form class="row container" method="post" action="create_devis.php">
         <input type="text" id="date" name="date" hidden />
         <div class="space"></div>
               <?php
               echo '<select class="form-control" onchange="researchService()" name="categService" id="categ_service_updt">';
               foreach ($categ['data'] as $result) {
                   if($result["statut"] == 1) {
                       echo '<option value="' . $result['idcategservice'] . '">' . $result['lb'] . '</option>';
                   }
               }
               ?>
                  <option value="" selected>--<?= t("Choisissez une catégorie de service")?>--</option>
               </select>
             <div class="row col-md-12" id="section_service">
             </div>
             <div class="space"></div>
             <div class="row mx-auto">
               <textarea placeholder="Description" name="description" id="description_service"></textarea>
             </div>
          </div>

          <div class="col-md-4" id="calendar">
            <div class="space"></div>
              <div class="row">
                  <div class="col-md-3">
                      <select class="form-control" name="clock" id="hours">
                          <?php for($i = 0 ; $i < 24; $i++){
                                  for ($j = 0; $j < 60; $j += 15) {
                                    echo '<option value="'. $i . ':' . $j . '">' . $i . ':' . $j . '</option>';
                                  }

                          }?>

                      </select>
                  </div>
                  <div class="space"></div>
                      <input onclick="checkAbo()" class="btn btn-primary w-100" value="Suivant">
              </div>
            </div>

        </form>
    </div>
</section>

<div id="service_alert">

</div>

<script type="text/javascript" src="rdv.js"></script>

<?php
include 'footer.php';
?>

<?php
  include 'header.php';
  include 'config.php';

  $context = stream_context_create(array(
      'http' => array(
          'method' => "GET",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  //Récupération des informations de l'utilisateur
  $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/SelectClient?iduser=" . $_SESSION['nmuser'], false, $context);
  $user_infos = json_decode($json, true);

  //Récupération de l'abonnement de l'utilisateur connecté
  if ($user_infos['data'][0]['idabonnement'] != null) {
    $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/abonnement?idabo=" . $user_infos['data'][0]['idabonnement'], false, $context);
    $user_abonnement = json_decode($json, true);

    $json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/unique_abonnement?idabo=" . $user_abonnement['data'][0]['idabonnement'], false, $context);
    $abonnement_infos = json_decode($json, true);

  }

 ?>

 <!DOCTYPE html>
 <html lang="fr" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
     <div id="actual_abo">
       <p><b>Mon abonnement : </b><?php echo isset($user_abonnement['data'][0]['statut']) == 0 ? "Pas d'abonnement en cours" : $abonnement_infos['data'][0]['lb']; ?></p>
       <p><b>Statut : </b><?php if (isset($user_abonnement['data'][0]['statut']) == 0) echo "Terminé"; else if (isset($user_abonnement['data'][0]['statut']) == 1) echo "En cours"; else echo "En attente de paiement"; ?></p>
       <p><b>Jour(s) restant(s) : </b><?php echo isset($user_abonnement['data'][0]['statut']) == 1 ? round((strtotime($user_abonnement['data'][0]['dtfin']) - time())/60/60/24) : "0"; ?></p>
    </div>

    <?php
    if ($user_infos['data'][0]['statutabo'] == null) {
     ?>
    <section class="container_fluid container_fluid_homePage">
      <div class="row d-flex justify-content-center">
        <div class="col-md-5 col_homePage">
          <div class="row d-flex justify-content-center title_my_row">
            <h3> Abonnements </h3>
          </div>
          <div class="row d-flex justify-content-center">
            <section class="form-elegant">
              <div class="card">
                <nav>
                  <ul class="nav nav-pills flex-column">
                    <?php


                         $json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/abonnement", false, $context);
                         $list_abonnements = json_decode($json, true);

                         foreach($list_abonnements['data'] as $abonnement) {
                           echo "<li class='d-flex justify-content-center'>";
                           echo "<div class='nav_item_position'>";
                           echo "<div onclick='displayModal(" . $abonnement['idabonnement'] . ")'>";
                           echo "<form action='subscribe_abonnement.php' method='POST'>";
                           echo "<h5 id='abo_title" . $abonnement['idabonnement'] . "'><b>" . $abonnement['lb'] . "</b></h5><br>";
                           echo "<p>" . $abonnement['description'] . "</p>";
                           echo $abonnement['nbrdispojour'] == 5 ? "<p id='abo_days" . $abonnement['idabonnement'] . "'>5jours/7 de " . $abonnement['horairedebut'] . " à " . $abonnement['horairefin'] . "</p>" : "<p id='abo_days" . $abonnement['idabonnement'] . "'>7jours/7 de " . $abonnement['horairedebut'] . " à " . $abonnement['horairefin'] . "</p>";
                           echo "<p id='abo_duration" . $abonnement['idabonnement'] . "'><b>Durée de l'abonnement : </b> " . $abonnement['cycleabo'] . " jours</p>";
                           echo "<p id='abo_price" . $abonnement['idabonnement'] . "'><b>Prix : </b>" . $abonnement['prix'] . "</p>";
                           echo "</form>";
                           echo "</div>";
                           echo "</div>";
                           echo "</li>";
                         }
                     ?>
                  </ul>
                </nav>
              </div>
            </section>
          </div>
        </div>
      </div>
    </section>
  <?php } ?>

      <div id="subscribe_alert">

      </div>

      <script src="abonnement.js"></script>
   </body>
 </html>

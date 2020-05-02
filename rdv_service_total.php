<?php
  include_once("./lang.php");
include 'config.php';
include 'header.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));
$requete = 'http://' . $_SESSION['ip_agence'] . '/intervention_fin?iduser=' . $_SESSION['nmuser'];
$json = file_get_contents($requete, false, $context);
$list_intervention = json_decode($json, true);


function getNameService($id)
{
    $context = stream_context_create(array(
        'http' => array(
            'method' => "GET",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    $requete = "http://" . $GLOBALS['IP_SIEGE'] . "/unique_service?service=" . $id;
    $json = file_get_contents($requete, false, $context);
    $liste_service = json_decode($json, true);

    //Vérification si il y a un nom pour le service sélectionné
    if ($liste_service['data'][0]['lb'] != ''){
        return $liste_service['data'][0]['lb'];
    }
    return '';
}

?>

<div class="container">
<h1>Liste des services</h1>
<ul class="list-group">
<?php
if($list_intervention != null){
foreach ($list_intervention['data'] as $intervention) {
    $date = new DateTime($intervention["dtcrea"]);
?>
    <li class="list-group-item" data-toggle="modal" data-target="#devismodal" data-whatever="@mdo" onclick="upd_devis(<?php echo $intervention['idintervention']; ?>)">
         <?= t("Rendez-vous pris le") ?> <strong><?= $date->format('Y-m-d') ?></strong> <?= t("pour le service suivant") ?> : <br>
        <strong><?php echo getNameService($intervention["idservice"]); ?></strong>
    </li>
<?php
}
?>

    </ul>
</div>

    <div class="modal fade" id="devismodal" tabindex="-1" role="dialog" aria-labelledby="iddossier_lb" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mettre fin à l'intervention</h5>
                    <form id="interventions_statut" method="POST" action="upt_intervention.php">
                        <input type="hidden" value="" name="idintervention" id="value_updt_id">
                        <input type="submit" value="Mettre fin à l'intervention"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="intervention.js"></script>
<?php
} else{
?>
<p><?php t("Pas d'intervention"); ?></p>
<?php
}
include 'footer.php';
?>

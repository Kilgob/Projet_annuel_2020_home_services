<?php
include 'config.php';
include 'header.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));
$requete = 'http://' . $_SESSION['ip_agence'] . '/intervention?iduser=' . $_SESSION['nmuser'];
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
    <li class="list-group-item">
        Rendez-vous pris le <strong><?= $date->format('Y-m-d') ?></strong> pour le service suivant : <br>
        <strong><?php echo getNameService($intervention["idservice"]); ?></strong>
    </li>
<?php
}
?>

</ul>
</div>

<?php
} else{
?>
<p>Pas de services</p>
<?php
}
include 'footer.php';
?>

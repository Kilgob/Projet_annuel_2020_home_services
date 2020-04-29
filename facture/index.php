<?php
session_start();
require('facturePDF.php');
include '../config.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

//Récupération de toutes les interventions du mois faites par ce même client
$json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/interventions_between_date?iduser=" . $_SESSION['nmuser'] . "&dtdebut=" . $_POST['dtdebut'] . "&dtfin=" . $_POST['dtfin'], false, $context);
$interventions = json_decode($json, true);

//Récupération des infos de la facture actuelle
$json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/facture_via_id?idfacture=" . $_POST['idfacture'], false, $context);
$facture_infos = json_decode($json, true);

//Récupération des informations de l'utilisateur
$json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/SelectClient?iduser=" . $_SESSION['nmuser'], false, $context);
$user_infos = json_decode($json, true);

//Récupération de l'id de l'abonnement correspondant aux dates de la facture
$request = str_replace(' ', '%20', "http://" . $_SESSION['ip_agence'] . "/prix_abonnement_facture?dtdebut=" . strftime("%Y-%m-%d %H:%M:%S", strtotime($facture_infos['data'][0]['dtdeb'])) . "&dtfin=" . strftime("%Y-%m-%d %H:%M:%S", strtotime($facture_infos['data'][0]['dtfin'])) . "&iduser=" . $_POST['iduser']);
$json = file_get_contents($request, false, $context);
$id_abo_actual_facture = json_decode($json, true);

//Récupération du prix de l'abonnement dans la table siège
// $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/abonnement?idabo=" . $user_infos['data'][0]['idabonnement'], false, $context);
// $id_abo_siege = json_decode($json, true);

$json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/unique_abonnement?idabo=" . $id_abo_actual_facture['data'][0]['idabonnement'], false, $context);
$abonnement_siege = json_decode($json, true);


// #1 initialise les informations de base
//
// adresse de l'entreprise qui émet la facture
$adresse = "HomeService\n242 rue du Faubourg Saint-Antoine\n75012 Paris\n\nhome.service@gmail.com\n(+33) 3 89 68 27 54";
// adresse du client
$adresseClient = $user_infos['data'][0]['prenom'] . " " . $user_infos['data'][0]['nom'] . "\n" . $user_infos['data'][0]['adresse'] . "\n" . $user_infos['data'][0]['ville'];
// initialise l'objet facturePDF
$pdf = new facturePDF($adresse, $adresseClient, "HomeService SA - 242 rue du Faubourg Saint-Antoine - 75012 Paris - home.service@gmail.com - (+33) 3 89 68 27 54\nTous services demandés est expressement dûs à l'entreprise. En cas de non paiement, aucunes autres demandes de services ne sera acceptées.\nRCS : 245-532-578- NANCY / TVA Intracomunautaire : FR 02 4578 1455 5578 3254 / SIRET 887 547 259 974 125");
// défini le logo
$pdf->setLogo('logo.png',15,15);
// entete des produits
$pdf->productHeaderAddRow('Service', 60, 'L');
$pdf->productHeaderAddRow('Date de début', 45, 'C');
$pdf->productHeaderAddRow('Date de fin', 45, 'C');
$pdf->productHeaderAddRow(' ', 0, 'C');
$pdf->productHeaderAddRow('Prix HT', 30, 'R');

// entete des totaux
$pdf->totalHeaderAddRow(40, 'L');
$pdf->totalHeaderAddRow(30, 'R');
// element personnalisé
$pdf->elementAdd('', 'traitEnteteProduit', 'content');
$pdf->elementAdd('', 'traitBas', 'footer');

// #2 Créer une facture
//
// numéro de facture, date, texte avant le numéro de page
$pdf->initFacture("Facture n° " . $_POST['idfacture'], "Paris le " . strftime("%d/%m/%Y", strtotime($facture_infos['data'][0]['dtfin'])) , "Page 1");
// produit
if ($interventions != []) {
  foreach ($interventions['data'] as $intervention) {
    $pdf->productAdd(array($intervention['description'], strftime("%d/%m/%Y %H:%M", strtotime($intervention['dtdeb'])), strftime("%d/%m/%Y %H:%M", strtotime($intervention['dtfin'])), '', $intervention['montantpresta'] + $intervention['montantsurplus']));
  }
}

//Ajout de l'abonnement en fin de page
$pdf->productAdd(array($abonnement_siege['data'][0]['lb'], "", "", "       " . $abonnement_siege['data'][0]['prix']));

// ligne des totaux
$pdf->totalAdd(array('Total HT', number_format($facture_infos['data'][0]['montant'] * 100/120,2)));
$pdf->totalAdd(array('TVA', number_format($facture_infos['data'][0]['montant'],2) - number_format($facture_infos['data'][0]['montant'] * 100/120,2)));
$pdf->totalAdd(array('Sous total TTC', number_format($facture_infos['data'][0]['montant'],2)));
//$pdf->totalAdd(array('Livraison', '100.00 EUR'));
//$pdf->totalAdd(array('Remise', '-5.94 EUR'));
//$pdf->totalAdd(array('Total TTC', '165.00 EUR'));

// #3 Importe le gabarit
//
require('gabarit0.php');

// #4 Finalisation
// construit le PDF
$pdf->buildPDF();
// télécharge le fichier
//$pdf->Output('Facture.pdf', $_GET['download'] ? 'D':'I');
$pdf->Output('Facture.pdf','I');
?>

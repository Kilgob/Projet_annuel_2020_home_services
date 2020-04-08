<?php
session_start();
require('facturePDF.php');
include '../config.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

//Récupération des informations de l'utilisateur
$json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/SelectClient?iduser=" . $_POST['iduser'], false, $context);
$user_infos = json_decode($json, true);

//Récupération de toutes les interventions du mois faites par ce même client
$json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/interventions_between_date?iduser=" . $_POST['iduser'] . "&dtdebut=" . $_POST['dtdebut'] . "&dtfin=" . $_POST['dtfin'], false, $context);
$interventions = json_decode($json, true);

// #1 initialise les informations de base
//
// adresse de l'entreprise qui émet la facture
$adresse = "HomeService\n242 rue du Faubourg Saint-Antoine\n75012 Paris\n\nhome.service@gmail.com\n(+33) 3 89 68 27 54";
// adresse du client
$adresseClient = $user_infos['data'][0]['prenom'] . " " . $user_infos['data'][0]['nom'] . "\n" . $user_infos['data'][0]['adresse'] . "\n" . $user_infos['data'][0]['ville'];
// initialise l'objet facturePDF
$pdf = new facturePDF($adresse, $adresseClient, "HomeService SA - 242 rue du Faubourg Saint-Antoine - 75012 Paris - home.service@gmail.com - (+33) 3 89 68 27 54\nLes produits livrés demeurent la propriété exclusive de notre entreprise jusqu'au paiement complet de la présente facture.\nRCS : 245-532-578- NANCY / TVA Intracomunautaire : FR 02 4578 1455 5578 3254 / SIRET 887 547 259 974 125");
// défini le logo
$pdf->setLogo('logo.png');
// entete des produits
$pdf->productHeaderAddRow('Produit', 75, 'L');
$pdf->productHeaderAddRow('Date de début', 40, 'C');
$pdf->productHeaderAddRow('Date de fin', 25, 'C');
$pdf->productHeaderAddRow('QTE', 15, 'C');
$pdf->productHeaderAddRow('Prix HT', 25, 'R');

// entete des totaux
$pdf->totalHeaderAddRow(40, 'L');
$pdf->totalHeaderAddRow(30, 'R');
// element personnalisé
$pdf->elementAdd('', 'traitEnteteProduit', 'content');
$pdf->elementAdd('', 'traitBas', 'footer');

// #2 Créer une facture
//
// numéro de facture, date, texte avant le numéro de page
$pdf->initFacture("Facture n° ".mt_rand(1, 99999), "Paris le " . date('d/m/yy') , "Page ");
// produit
foreach ($interventions['data'] as $intervention) {
  $pdf->productAdd(array($intervention['description'], 'ICI DATE DEBUT', 'ICI DATE FIN', '', $intervention['montantpresta']));
}
$pdf->productAdd(array('Scotch', 'COUCOU', '10.00', '100', '1000.00'));
$pdf->productAdd(array('Bouche', 'BOUUUUCHE', '5.00', '7', '35.00'));
$pdf->productAdd(array('FRED', 'NOOOOB', '0.01', '1', '0.01'));

// ligne des totaux
$pdf->totalAdd(array('Total HT', '1035.01 EUR'));
$pdf->totalAdd(array('TVA', '10.99 EUR'));
$pdf->totalAdd(array('Sous total TTC', '71.94 EUR'));
$pdf->totalAdd(array('Livraison', '100.00 EUR'));
$pdf->totalAdd(array('Remise', '-5.94 EUR'));
$pdf->totalAdd(array('Total TTC', '165.00 EUR'));

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

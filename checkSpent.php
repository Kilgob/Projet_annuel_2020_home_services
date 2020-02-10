<?php
//Page appelée lors d'arriver sur la paga facture ou bien la page demande de service
// afin d'empêcher de choisir un nouveau service et de pouvoir faire payer le bon montant
    session_start();
    $json=file_get_contents("http://172.16.69.181:6002/serviceunpaidfromuser?iduser=" . $_SESSION['nmuser'], false, $context);//fonctionne ?

    $servicePending=json_decode($json, true);

    // $user_infos['data'][0]['iduser']

    if($servicePending['data'][0]['lb'] != NULL){
        if($_SESSION['data'][0]['cdabonement'] == 0){//si user n'a pas d'abonnement
            echo "<p>vous avez une nouvelle facture : " . $servicePending['data'][0]['lb'] . $servicePending['data'][0]['numservice'] . "<br></p>";
        }
        else{//si user a un abonnement
            //récupérer la date de renouvellement de l'abonnement pour ensuite créer la facture avec tous les services non payés
            //if(date...){
            //
            //}

            //boucle si il est temps de recréer une facture
            echo "les services non payés : ";
            foreach ($servicePending['data'] as $service){
                echo "- " . $service['lb'] . $service['numservice'] . "<br>";
            }
        }
    }
    else{//si user n'a pas de facture
    echo "<p>vous n'avez pas de nouvelles factures : " . $servicePending['data'][0]['lb'] . $servicePending['data'][0]['numservice'] . "<br></p>";
    }


?>
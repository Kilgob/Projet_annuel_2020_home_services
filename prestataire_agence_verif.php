<?php
session_start();
include 'config.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

    $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence_get_ip?idagence=" . $_GET['idagence'], false, $context);
    $infoAgence=json_decode($json, true);

    $requete = "http://" . $infoAgence['data'][0]['ip'] . ":" . $infoAgence['data'][0]['port'] . "/prestataire";
    $json = file_get_contents($requete, false, $context);
    $liste_prestataire=json_decode($json, true);

?>


<div id="new_prest" class="row d-flex justify-content-center">
    <div class="form-elegant" >
        <div class="card">
            <nav>
                <ul id="display_users" class="nav nav-pills flex-column ">

                    <?php

                    foreach($liste_prestataire['data'] as $folder){

                        if($folder['okactif'] != "0"){
                            echo '<li  onclick="research(' . $folder['iduser'] . ')" class="d-flex justify-content-center">';
                            echo '<div class="nav_item_position_folders">';
                            echo '<p>Prestataire ' . $folder['iduser'] . ' :<br>' . $folder['mail'] . '</p>';
                            echo '</div></li>';
                        }
                        else{
                            echo '<li class="nav-item_en_cours">';
                            echo '<div id="en_cours" class="nav_item_position_folders_yellow">';
                            echo '<p>Prestataire ' . $folder['iduser'] . ' :<br>' . $folder['mail'] . '<br>(En attente de validation)</p>';
                            echo '</div></li>';
                        }
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

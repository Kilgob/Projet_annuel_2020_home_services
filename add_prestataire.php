<?php
    include 'header.php';
    include 'config.php';
    // SELECT nom,prenom,addrmail,notel FROM tabusers WHERE nmuser = ?
    $context = stream_context_create(array(
        'http' => array(
            'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
    ));

    $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/categ_service", false, $context);
    $categ_service=json_decode($json, true);

    $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence", false, $context);
    $listeAgence=json_decode($json, true);

    // lister tous les services (pas utilisé)
    $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/service", false, $context);
    $listeService=json_decode($json, true);
?>

<main>
    <section class="row d-flex justify-content-center">
        <div class="col-md-5 d-flex justify-content-center">
            <div id="user_profil_form">
                <form method="POST" action="add_prestataire_back.php">
                    <h3 class="title_my_row">Nouveau prestataire</h3>
                    <div class="d-flex justify-content-center">
                        <div class="form-group row user_profil_input_row">
                            <div class="mx-auto user_profil_align">

                                <div class="form-group display_input_inline_block">
                                    <input type='text' class="form-control" placeholder="Prénom" aria-label="firstname" aria-describedby="basic-addon1" value="" name="prenom" />
                                    <input type='text' class="form-control" placeholder="Nom" aria-label="lastname" aria-describedby="basic-addon1" value="" name="nom" />
                                </div>
                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="Email" aria-label="email" aria-describedby="basic-addon1" value="" size="30" name="mail" />
                                </div>
                                <div class="form-group">
                                    <input type='password' class="form-control" placeholder="mot de passe" aria-label="password" aria-describedby="basic-addon1" value="" size="30" name="password" />
                                </div>
                                <div id="user_profil_address_and_num_div" class="form-group">
                                    <input id="user_profil_address_input" type="text" class="form-control" placeholder="Adresse" aria-label="address" aria-describedby="basic-addon1" value="" name="adresse" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input_247px" placeholder="Ville" aria-label="town" aria-describedby="basic-addon1" value="" name="ville" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input_247px" placeholder="Numéro de téléphone" aria-label="num_tel" aria-describedby="basic-addon1" value="" name="notel" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <select onchange="finAgence()" name="agence_selected" id="agence_select_service">
                            <?php foreach ($listeAgence['data'] as $result) {
                                echo '<option value="' . $result['idagence'] . '">' . $result['nom'] . " (" . $result['ville'] . ')</option>';
                            } ?>

                            <option value="" selected>--Assignez à une agence--</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="categService" id="categ_service_updt">
                            <option value="" selected>--Selectionnez d'abord une agence--</option>
                        </select>
                    </div>
                    <input class="btn btn-secondary" type='submit' value="Confirmer la création du nouveau Prestataire" />
                </div>
            </form>
        </div>
    </section>
</main>
<script type="text/javascript" src="checkCategAndService.js"></script>

<?php
include 'footer.php';
?>

<?php
include 'header.php';
include 'config.php';
    // SELECT nom,prenom,addrmail,notel FROM tabusers WHERE nmuser = ?
    $context = stream_context_create(array(
        'http' => array(
            'method' => "GET",
            'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
    ));


    $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence", false, $context);
    $listeAgence=json_decode($json, true);

//    $json=file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/service", false, $context);
//    $listeService=json_decode($json, true);
    /*
    $json=file_get_contents("http://172.16.69.181:6002/user_adresse?idadresse=1", false, $context);
    $user_adress=json_decode($json, true);*/


// SELECT num_rue,nom_rue,lbville FROM tabadresses INNER JOIN tabvilles WHERE idadresse = :idadresse AND tabvilles.idville = tabadresses.idville
?>

<main>
    <section class="row d-flex justify-content-center">
        <div class="col-md-5 d-flex justify-content-center">
            <div id="user_profil_form">

                <form method="POST" action="new_agence.php"><!--http://172.16.69.181:6001/create_type_service?lb=service1-->
                    <h4 class="title_my_row">Créer une nouvelle agence locale</h4>
                    <div class="d-flex justify-content-center">
                        <div class="form-group row user_profil_input_row">
                            <div class="mx-auto user_profil_align">

                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="Nom de la nouvelle agence" aria-label="ageceName" aria-describedby="basic-addon1" value="" name="name_agence" />
                                </div>
                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="ville de la nouvelle agence" aria-label="ageceName" aria-describedby="basic-addon1" value="" name="city_agence" />
                                </div>
                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="ip" aria-label="ageceName" aria-describedby="basic-addon1" value="" name="ip" />
                                </div>
                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="port" aria-label="ageceName" aria-describedby="basic-addon1" value="" name="port" />
                                </div>


                                <input class="btn btn-secondary" type='submit' value="Confirmer la nouvelle agence" />
                            </div>
                        </div>
                    </div>
                </form>

                <form method="POST" action="new_type_service.php"><!--http://172.16.69.181:6001/create_type_service?lb=service1-->
                    <h4 class="title_my_row">Créer un type de service</h4>
                    <div class="d-flex justify-content-center">
                        <div class="form-group row user_profil_input_row">
                            <div class="mx-auto user_profil_align">

                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="Nom du type de services" aria-label="firstname" aria-describedby="basic-addon1" value="" name="name_service" />
                                </div>

                                <div class="form-group">
                                    <select name="agence_selected" id="agence-select_agence">
                                        <?php foreach ($listeAgence['data'] as $result) {
                                            echo '<option value="' . $result['idagence'] . '">' . $result['nom'] . " (" . $result['ville'] . ')</option>';
                                        } ?>

                                        <option value="" selected>--Ratacher la catégorie à une agence--</option>
                                    </select>
                                </div>

                                <input class="btn btn-secondary" type='submit' value="Confirmer le nouveau type de service" />
                            </div>
                        </div>
                    </div>
                </form>

                <form method="POST" action="new_service.php">
                    <h4 class="title_my_row">Créer un service</h4>
                    <div class="d-flex justify-content-center">
                        <div class="form-group row user_profil_input_row">
                            <div class="mx-auto user_profil_align">

                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="Nom du service" aria-label="firstname" aria-describedby="basic-addon1" value="" name="service" />
                                </div>
                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="Prix" aria-label="lastname" aria-describedby="basic-addon1" value="" name="price" />
                                </div>
                                <div class="form-group">
                                    <select onchange="finAgence()" name="agence_selected" id="agence_select_service">
                                        <?php foreach ($listeAgence['data'] as $result) {
                                            echo '<option value="' . $result['idagence'] . '">' . $result['nom'] . " (" . $result['ville'] . ')</option>';
                                        } ?>

                                        <option value="" selected>--Choisissez une agence--</option>
                                    </select>
                                </div>
                                <div class="form-group" id="categ_service_updt">
                                    <select name="categService" id="categ-service-select">
                                        <option value="" selected>--Catégorie--</option>
                                    </select>
                                </div>


                                <input class="btn btn-secondary" type='submit' value="Confirmer la création du nouveau service" />
                            </div>
                        </div>
                    </div>
                </form>

                <form method="POST" action="new_abonnement.php">
                    <h4 class="title_my_row">Créer un nouvel abonnement</h4>
                    <div class="d-flex justify-content-center">
                        <div class="form-group row user_profil_input_row">
                            <div class="mx-auto user_profil_align">

                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="Nom du nouvel abonnement" aria-label="firstname" aria-describedby="basic-addon1" value="" name="name_abonnement" />
                                </div>
                                <div class="form-group">
                                    <input type='number' class="form-control" placeholder="prix" aria-describedby="basic-addon1" value="" name="price" />
                                </div>
                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="description" aria-describedby="basic-addon1" value="" name="description" />
                                </div>
                                <div class="form-group">
                                    <input type='number' class="form-control" placeholder="nombre de jour cumulable" aria-describedby="basic-addon1" value="" name="nbr_days_cumul" />
                                    <i>
                                        7 = 7/7 --> lundi au dimance<br>
                                        6 = 6/7 --> lundi au samedi<br>
                                        5 = 5/7 --> lundi au vendredi<br>
                                        4 = 4/7 --> lundi - mardi, jeudi - vendredi<br>
                                    </i>
                                </div>
                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="horaire de début" aria-describedby="basic-addon1" value="00:01" name="hr_start" />
                                    <i>
                                        Horaire du début de prise de services compris dans l'abonnement<br>
                                        Syntaxe : --:--<br>
                                    </i>
                                </div>
                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="horaire de fin" aria-describedby="basic-addon1" value="23:59" name="hr_end" />
                                    <i>
                                        Horaire de fin de prise de services compris dans l'abonnement<br>
                                        Syntaxe : --:--<br>
                                    </i>
                                </div>
                                <div class="form-group">
                                    <input type='number' class="form-control" placeholder="durée de l'abonnement" aria-describedby="basic-addon1" value="30" name="nbr_days_abos" />
                                    <i>
                                        Nombre de jour avant le renouvellement de l'abonnemnt<br>
                                        Syntaxe : nombre de jours<br>
                                    </i>
                                </div>

                                <div class="form-group">
                                    <select name="agence_selected" id="agence_select_abonnement">
                                        <?php foreach ($listeAgence['data'] as $result) {
                                            echo '<option value="' . $result['idagence'] . '">' . $result['nom'] . " (" . $result['ville'] . ')</option>';
                                        } ?>

                                        <option value="" selected>--Ratacher l'abonnement à une agence--</option>
                                    </select>
                                </div>

                                <input class="btn btn-secondary" type='submit' value="Confirmer le nouvel abonnement" />
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
    <script type="text/javascript" src="checkCategAndService.js"></script>

</main>

<?php
    include 'footer.php';
?>

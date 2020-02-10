<?php
include 'header.php';
include 'config.php';
    // SELECT nom,prenom,addrmail,notel FROM tabusers WHERE nmuser = ?
    $context = stream_context_create(array(
        'http' => array(
            'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
    ));

    $json=file_get_contents("http://172.16.69.181:6002/user?iduser=1", false, $context);
    $user_compl=json_decode($json, true);

/*
    $json=file_get_contents("http://172.16.69.181:6002/user_adresse?idadresse=1", false, $context);
    $user_adress=json_decode($json, true);
*/


// SELECT num_rue,nom_rue,lbville FROM tabadresses INNER JOIN tabvilles WHERE idadresse = :idadresse AND tabvilles.idville = tabadresses.idville
?>

<main>
    <section class="row d-flex justify-content-center">
        <div class="col-md-5 d-flex justify-content-center">
            <div id="user_profil_form">
                <form method="POST" action="user_account_modify.php">
                    <h3 class="title_my_row">Vos informations</h3>
                    <div class="d-flex justify-content-center">
                        <div class="form-group row user_profil_input_row">
                            <div class="mx-auto user_profil_align">

                                <div class="form-group display_input_inline_block">
                                    <input type='text' class="form-control" placeholder="Prénom" aria-label="firstname" aria-describedby="basic-addon1" value="<?php echo $user_compl['data'][0]['prenom']; ?>" name="prenom" />
                                    <input type='text' class="form-control" placeholder="Nom" aria-label="lastname" aria-describedby="basic-addon1" value="<?php echo $user_compl['data'][0]['nom']; ?>" name="nom" />
                                </div>

                                <div class="form-group">
                                    <input type='text' class="form-control" placeholder="Email" aria-label="email" aria-describedby="basic-addon1" value="<?php echo $user_compl['data'][0]['mail']; ?>" size="30" name="addrmail" />
                                </div>

                                <div id="user_profil_address_and_num_div" class="form-group">
                                    <input id="user_profil_address_input" type="text" class="form-control" placeholder="Adresse" aria-label="address" aria-describedby="basic-addon1" value="<?php echo $_SESSION['adresse']; ?>" name="nom_rue" />
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control input_247px" placeholder="Ville" aria-label="town" aria-describedby="basic-addon1" value="<?php echo $_SESSION['ville']; ?>" name="lbville" />
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control input_247px" placeholder="Numéro de téléphone" aria-label="num_tel" aria-describedby="basic-addon1" value="<?php echo $user_compl['data'][0]['notel'];?>" name="notel" />
                                </div>

                                <input class="btn btn-secondary" type="submit" value="Valider les changements" />
                                <a href="user_account_delete.php"><input class="btn btn-secondary" type="button" value="Supprimer son compte" /></a>
                                <input type='hidden' value="<?php echo $_SESSION['nmuser']; ?>" /><br><br>

                            </div>
                        </div>
                    </div>
                </form>

                <form method="POST" action="password_modify.php">
                    <div class="d-flex justify-content-center">
                        <div class="form-group row user_profil_input_row">
                            <div class="mx-auto user_profil_align">

                                <div class="form-group">
                                    <input type='password' class="form-control" placeholder="Ancien mot de passe" aria-label="ancien_mdp" aria-describedby="basic-addon1" name="old_password" />
                                </div>

                                <div class="form-group">
                                    <input type='password' class="form-control" placeholder="Nouveau mot de passe" aria-label="mdp" aria-describedby="basic-addon1" name="password" />
                                </div>

                                <div class="form-group">
                                    <input type='password' class="form-control" placeholder="Confirmation mot de passe" aria-label="confirm_mdp" aria-describedby="basic-addon1"  name="confirm_password" size="25" />
                                </div>

                                <input class="btn btn-secondary" type='submit' value="Modifier" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php

    if(isset($_GET['msg']) && $_GET['msg'] == 'password_modify_succes'){
        echo '<p style="color:rgb(90,98,104);text-align:center;">Votre mot de passe a été modifié avec succès !</p>';
    }

    if(isset($_GET['error'])){

        if($_GET['error'] == 'email_missing'){
            echo '<p style="color:rgb(90,98,104);text-align:center;">L\'adresse mail n\'est pas renseignée !</p>';
        }

        if($_GET['error'] == 'email_format'){
            echo '<p style="color:rgb(90,98,104);text-align:center;">L\'email n\'est pas correct !</p>';
        }

        if($_GET['error'] == 'address_num_missing'){
            echo '<p style="color:rgb(90,98,104);text-align:center;">Le numéro de rue est manquant ou invalide !</p>';
        }

        if($_GET['error'] == 'address_missing'){
            echo '<p style="color:rgb(90,98,104);text-align:center;">L\'adresse postal n\'est pas renseignée !</p>';
        }

        if($_GET['error'] == 'town_dont_exist'){
            echo '<p style="color:rgb(90,98,104);text-align:center;">La ville choisie n\'exite pas !</p>';
        }

        if($_GET['error'] == 'num_tel_missing'){
            echo '<p style="color:rgb(90,98,104);text-align:center;">Le numéro de téléphone n\'est pas renseigné !</p>';
        }

        if($_GET['error'] == 'modify_succes'){
            echo '<p style="color:rgb(90,98,104);text-align:center;">Votre compte a été modifié avec succès !</p>';
        }

        if($_GET['error'] == 'wrong_old_password'){
            echo '<p style="color:rgb(90,98,104);text-align:center;">Votre mot de passe actuel ne correspond pas avec celui renseigné !</p>';
        }

        if($_GET['error'] == 'password_dont_correspond'){
            echo '<p style="color:rgb(90,98,104);text-align:center;">Les nouveaux mots de passes renseignés ne correspondent pas !</p>';
        }
    }
    ?>


</main>

<?php
include 'footer.php';
?>

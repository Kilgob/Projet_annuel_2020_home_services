<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>NextHome</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style_header.css" />
    <link rel="stylesheet" href="css/style_main.css" />
    <link rel="stylesheet" href="css/style_liste_dossier.css" />
    <link rel="stylesheet" href="css/style_inscription.css" />
      <link rel="stylesheet" href="css/rdv_service.css" />
      <!-- <link rel="stylesheet" href="css/style_homePage.css"/>
      <link rel="stylesheet" href="css/style_general_manage.css" />
      <link rel="stylesheet" href="css/style_liste_dossier.css" />

      <link rel="stylesheet" href="css/style_user_profil.css" />
      <link rel="stylesheet" href="css/style_users_management.css" />
      <link rel="stylesheet" href="css/style_rdv_management.css" />
      <link rel="stylesheet" href="css/style_ConnexionIndex.css" />
      <link rel="stylesheet" href="css/style_email_modify_password.css" />
      <link rel="stylesheet" href="css/style_presentation.css" /> -->
    <link rel="stylesheet" href="css/style_footer.css" />
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">

              <a class="nav-link" href=" <?php if(!isset($_SESSION['nmuser'])){echo 'index.php';}else{echo 'create_Service.php';}  ?>">Accueil<span class="sr-only">(current)</span></a>
            </li>
            <?php
                if(isset($_SESSION['cdtype_user']) && $_SESSION['cdtype_user'] == 'pat'){
            ?>
            <li class="nav_item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admistration</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuAdmin">
                <a class="dropdown-item" href="create_service.php">Créer un service</a>
                <a class="dropdown-item" href="add_prestataire.php">Nouveau presatataire</a>
                <a class="dropdown-item" href="prestataire.php">Page de gestion</a>
              </div>
            </li>
          <?php }
           if(isset($_SESSION['nmuser']) && $_SESSION['cdtype_user'] == 'cli'){ ?>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Vos services
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuUser">
                       <a class="nav-link" href="rdv_service.php">Demander un service</a>
                       <a class="nav-link" href="abonnement.php">Abonnement</a>
                       <a class="nav-link" href="rdv_service_total.php">Liste des services en cours</a>
                       <a class="nav-link" href="devis.php">Devis</a>
                       <a class="nav-link" href="facture_client.php">Mes factures</a>
                       <a class="dropdown-item" href="paiement.php">Page de paiement</a>
                  </div>
              </li>
            <?php
            }
          ?>
          <?php
          if(isset($_SESSION['cdtype_user']) && $_SESSION['cdtype_user'] == 'pre'){
          ?>
          <li class="nav_item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Rendez-vous</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuAdmin">
                  <a class="dropdown-item" href="rdv_service_pre.php">Devis</a>
                  <a class="dropdown-item" href="rdv_service_total_pre.php">Intervention</a>
              </div>
          </li>
          <?php } ?>
            <li class="nav-item">
              <a class="nav-link" href="contact.php" id="navbarDropdownMenuLink">
                <img src="image/Symboles/position.png">
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="image/Symboles/account.png">
              </a>
              <?php if(isset($_SESSION['nmuser']) && $_SESSION != []){ ?>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuUser">
                  <a class="dropdown-item" href="user_profil.php">Profil</a>
                  <a class="dropdown-item" href="disconnect.php">Deconnexion</a>
                </div>
              <?php }
              else{ ?>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="ConnexionIndex.php">Connexion</a>
                <a class="dropdown-item" href="inscription.php">Inscription</a>
              </div>
            <?php } ?>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <script src="js/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
    <script src="js/bootstrap.min.js"></script>

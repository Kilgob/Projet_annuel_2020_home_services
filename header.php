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

              <a class="nav-link" href=" <?php if(!isset($_SESSION['nmuser'])){echo 'index.php';}else{echo 'create_Service.php';}  ?>"><?= t("Accueil") ?><span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tarifs.php"><?= t("Tarifs") ?></a>
            </li>
            <?php
                if($_SESSION != [] && ($_SESSION['cdtype_user'] != 'cli' || $_SESSION['cdtype_user'] == 'pre')){
            ?>
            <li class="nav_item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= t("Admistration") ?></a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuAdmin">
                <a class="dropdown-item" href="create_service.php"><?= t("Créer un service") ?></a>
                <a class="dropdown-item" href="add_prestataire.php"><?= t("Nouveau presatataire") ?></a>
                <a class="dropdown-item" href="prestataire.php"><?= t("Page de gestion") ?></a>
                <a class="dropdown-item" href="create_service.php">Créer un service</a>
                <a class="dropdown-item" href="add_prestataire.php">Nouveau presatataire</a>
                <a class="dropdown-item" href="prestataire.php">Page de gestion</a>
              </div>
            </li>
          <?php }
           if(isset($_SESSION['nmuser']) && $_SESSION['cdtype_user'] == 'cli'){ ?>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?= t("Vos services") ?>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuUser">
                       <a class="nav-link" href="rdv_service.php">Demander un service</a>
                       <a class="nav-link" href="rdv_service_total.php">Liste des services en cours</a>
                      <a class="nav-link" href="manage_my_account.php">Mes informations personnelles</a>
                  </div>
              </li>
            <?php
            }
          ?>
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
                  <a class="dropdown-item" href="user_profil.php"><?= t("Profil") ?></a>
                  <a class="dropdown-item" href="disconnect.php"><?= t("Deconnexion") ?></a>
                </div>
              <?php }
              else{ ?>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="ConnexionIndex.php"><?= t("Connexion") ?></a>
                <a class="dropdown-item" href="inscription.php"><?= t("Inscription") ?></a>
              </div>
            <?php } ?>
            </li>
          </ul>
          <!-- Dropdown pour choisir le language -->
          <div class="nav-item">
              <form method="get" action="changer_language.php">
                <div class="form-inline row">
                  <select name="lang" class="form-control col-6">
                    <?php foreach($GLOBALS["traductions"] as $traduction){
                      ?> <option value="<?= $traduction ?>" <?= $_SESSION["lang"] == $traduction ? "selected" : "" ?>><?= $traduction ?></option> <?php
                    }
                    ?>
                  </select>
                  <button type="submit" class="btn btn-secondary col-6">Ok</button>
               </div>
              </form>
          </div>
        </div>
      </nav>
    </header>
    <script src="js/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
    <script src="js/bootstrap.min.js"></script>
<?php
  include('config.php');
  include_once("lang.php");
  include('./header.php');
?>

  <main>
    <section class="container-fluid" id="accueil_banner">
    </section>

    <section>
      <div class="row">

        <div class="col-md-1" id="right_side">
        </div>

        <div class="col-md-4" id="right_side">
          <br>
          <h1><?= t("Bienvenue chez NextHome !") ?></h1>
          <br>
          <p><?= t("On espère que nos services seront à la hauteur de vos attentes") ?></p>
          <br>

        </div>

      </div>
    </section>
  </main>

<?php
  include('footer.php');
?>

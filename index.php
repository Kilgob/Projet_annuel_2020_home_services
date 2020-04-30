
<?php
  include('header.php');
  include('config.php');
  require_once 'VerificationAbonnement.php';
  echo strftime("%d/%m/%Y %H:%M:%S");

  
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
          <h1>Bienvenue chez NextHome !</h1>
          <br>
          <p>On espère que nos services seront à la hauteur de vos attentes</p>
          <br>

        </div>

      </div>
    </section>
  </main>

<?php
  include('footer.php');
?>

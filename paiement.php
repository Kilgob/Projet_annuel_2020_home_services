<?php
include 'header.php';
include 'stripe-php-master/init.php';

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Paiement TEST</title>
    <link rel="stylesheet" href="css/style_paiement.css"/>
  </head>
  <body>

    <form action="succes.php" method="post" id="payment-form">
      <div class="form-row">
        <label for="card-element">
          Credit or debit card
        </label>
        <div id="card-element">
          <!-- A Stripe Element will be inserted here. -->
        </div>

      <!-- Used to display Element errors. -->
        <div id="card-errors" role="alert"></div>
      </div>

      <button>Submit Payment</button>
    </form>

    <!-- <script src="js/stripev3.js"></script> -->
    <script src="js/stripev3.js"></script>
    <script src="charge.js"></script>
  </body>
</html>

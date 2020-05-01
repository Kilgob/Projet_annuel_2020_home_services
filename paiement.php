<?php
  include 'header.php';
  include 'stripe-php-master/init.php';

  $context = stream_context_create(array(
      'http' => array(
          'method' => "GET",
          'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
  ));

  $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/facture_np?iduser=" . $_SESSION['nmuser'], false, $context);
  $facture_np = json_decode($json, true);

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Paiement TEST</title>
    <link rel="stylesheet" href="css/style_paiement.css"/>
  </head>
  <body>

  <?php
    if ($facture_np != []) {
   ?>
      <form action="paiement_accepted.php" method="post" id="payment-form">
        <p><b><?php echo $facture_np['data'][0]['lb']; ?></b></p>
        <p><b>Montant à payer : </b><?php echo $facture_np['data'][0]['montant']; ?></p>
        <input type="hidden" value="<?php echo $facture_np['data'][0]['idfacture'];?>" name="idfacture"/>
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
<?php
      if (isset($_GET['error']) && $_GET['error'] == 'pay') {
        echo "Il vous faut impérativement régler la facture avant de pouvoir accéder à vos services ;)";
      }
    }
    else {
      echo "Il n'y a pas de facture à payer, vous êtes à jour !";
    }
    ?>

    <script src="js/stripev3.js"></script>
    <script src="charge.js"></script>
  </body>
  <?php include 'footer.php'; ?>
</html>

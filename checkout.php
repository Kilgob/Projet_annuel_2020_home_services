<?php

require_once 'stripe-php-master/init.php';

// Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_NauNIpHtySVEOCi8loGgwoQl00TOmhj7bJ');

// Token is created using Stripe Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['stripeToken'];
$charge = \Stripe\Charge::create([
  'amount' => 999,
  'currency' => 'eur',
  'description' => 'Example charge',
  'source' => $token,
]);

?>

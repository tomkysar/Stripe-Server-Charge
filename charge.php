<?php
require_once('./server/stripe-php/init.php');

\Stripe\Stripe::setApiKey("YOUR_API-KEY");

$token = $_POST['stripeToken'];
$email = $_POST['stripeEmail'];

try {

  $customer = Stripe_Customer::create(array(
      'email' => $email,
      'card' => $token
  ));
    
  $charge = Stripe_Charge::create(array(
      'customer' => $customer->id,
      'amount' => 9990,
      'currency' => 'usd',
      'description' => 'YOUR_PRODUCT_DESCRIPTION'
  ));
    
  header("Location: YOUR_REDIRECT_SUCCESS_LINK");
  
  exit();    
}

catch (\Stripe\Error\Card $e) {

  $errorMessage = $e->getMessage();

  $json         = array(
      'completion' => $errorMessage
  );

  echo json_encode($json);
  header("Location: YOUR_REDIRECT_ERROR_LINK");

  exit();
}
?>
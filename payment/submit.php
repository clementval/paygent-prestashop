<?php

include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../../init.php');

include_once(_PS_MODULE_DIR_.'paygent/classes/paygent.php');


$paygent = new Paygent();
$paygent->load_configuration();
$paygent_action = Configuration::get('PAYGENT_ACTION_URL');
$merchant_id = $paygent->get_merchant_id();
$trading_id = $cart->id;
$id = $cart->getOrderTotal(true);
$customer_id = $cart->id_customer;
$payment_class = "0";
$payment_type = "02";
$use_card_conf_number = "1";
$paygent->set_trading_id($trading_id);
$paygent->set_payment_type($payment_type);
$paygent->set_id($id);
$paygent->set_customer_id($customer_id);
$paygent->set_payment_class($payment_class);
$paygent->set_use_card_conf_number($use_card_conf_number);
$hash = $paygent->generate_hash();
?>

<html>
<head></head>
<body>
Redirecting to Paygent credit card service ...

<form method="POST" action="<?= $paygent_action ?>">
  <input type="hidden" name="trading_id" value="<?= $trading_id ?>" /> <!-- transaction id -->
  <input type="hidden" name="payment_type" value="<?= $payment_type ?>" />
  <input type="hidden" name="id" value="<?= $id ?>" /> <!-- amount -->
  <input type="hidden" name="seq_merchant_id" value="<?= $merchant_id ?>" />
  <input type="hidden" name="payment_class" value="<?= $payment_class ?>" />
  <input type="hidden" name="use_card_conf_number" value="<?= $use_card_conf_number ?>" />
  <input type="hidden" name="customer_id" value="<?= $customer_id ?>" />
  <input type="hidden" name="hc" value="<?= $hash ?>" />
  <input type="submit" value="Payer" />
</form>
</body>
</html>

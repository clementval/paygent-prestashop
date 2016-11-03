<?php

include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../../init.php');

include_once(_PS_MODULE_DIR_.'paygent/classes/paygent.php');

global $smarty;
global $cart;
$return_url = $smarty->tpl_vars['base_dir'].'history.php';
$paygent = new Paygent();
$paygent->load_configuration();
$paygent_action = Configuration::get('PAYGENT_ACTION_URL');
$merchant_id = $paygent->get_merchant_id();
$trading_id = $_POST["test_trading_id"];
$id = $_POST["test_amount"];
$customer_id = $_POST["test_customer_id"];
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

$paygent->insert_transaction();
?>
<html>
  <head>
    <title>Paygent</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  </head>
  <body>
    <p>
        <h2>Test information</h2>
        Trading ID: <?= $trading_id ?></br>
        Amount: <?= $id ?></br>
        Customer ID: <?= $customer_id ?></br>
    </p>
  <body>
    <form method="POST" action="<?= $paygent_action ?>" class="hiddent" id="paygent_form">
      <input type="hidden" name="trading_id" value="<?= $trading_id ?>" /> <!-- transaction id -->
      <input type="hidden" name="payment_type" value="<?= $payment_type ?>" />
      <input type="hidden" name="id" value="<?= $id ?>" /> <!-- amount -->
      <input type="hidden" name="seq_merchant_id" value="<?= $merchant_id ?>" />
      <input type="hidden" name="payment_class" value="<?= $payment_class ?>" />
      <input type="hidden" name="use_card_conf_number" value="<?= $use_card_conf_number ?>" />
      <input type="hidden" name="customer_id" value="<?= $customer_id ?>" />
      <input type="hidden" name="return_url" value="<?= $return_url ?>" />
      <input type="hidden" name="hc" value="<?= $hash ?>" />
      <input type="submit" value="Pay"/> <!-- to be removed after dev -->
    </form>
  </body>
</html>
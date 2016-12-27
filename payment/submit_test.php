<?php

include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../../init.php');

include_once(_PS_MODULE_DIR_.'paygent/classes/paygent_helper.php');

global $smarty;
global $cart;
$return_url = $smarty->tpl_vars['base_dir'].'history.php';
$paygent_helper = new PaygentHelper();
$paygent_helper->load_configuration();
$paygent_action = Configuration::get('PAYGENT_ACTION_URL');
$merchant_id = $paygent_helper->get_merchant_id();
$trading_id = trim($_POST["test_trading_id"]);
$id = trim($_POST["test_amount"]);
$customer_id = trim($_POST["test_customer_id"]);
$payment_class = "0";
$payment_type = "02";
$use_card_conf_number = "1";
$pay_term_min = "15";
$paygent_helper->set_trading_id($trading_id);
$paygent_helper->set_payment_type($payment_type);
$paygent_helper->set_id($id);
$paygent_helper->set_customer_id($customer_id);
$paygent_helper->set_payment_class($payment_class);
$paygent_helper->set_use_card_conf_number($use_card_conf_number);
$paygent_helper->set_payment_term_min($pay_term_min);
$hash = $paygent_helper->generate_hash();

$paygent_helper->insert_transaction();

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
      <input type="hidden" name="language_code" value="en" />
      <input type="hidden" name="currency_code" value="EUR" />
      <input type="hidden" name="trading_id" value="<?= $trading_id ?>" /> <!-- transaction id -->
      <input type="hidden" name="payment_type" value="<?= $payment_type ?>" />
      <input type="hidden" name="id" value="<?= $id ?>" /> <!-- amount -->
      <input type="hidden" name="seq_merchant_id" value="<?= $merchant_id ?>" />
      <input type="hidden" name="payment_class" value="<?= $payment_class ?>" />
      <input type="hidden" name="use_card_conf_number" value="<?= $use_card_conf_number ?>" />
      <input type="hidden" name="payment_term_min" value="<?= $pay_term_min ?>" />
      <input type="hidden" name="customer_id" value="<?= $customer_id ?>" />
      <input type="hidden" name="return_url" value="<?= $return_url ?>" />
      <input type="hidden" name="hc" value="<?= $hash ?>" />
      <input type="submit" value="Pay"/> <!-- to be removed after dev -->
    </form>
  </body>
</html>

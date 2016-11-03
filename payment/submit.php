<?php

include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../../init.php');

include_once(_PS_MODULE_DIR_.'paygent/classes/paygent_helper.php');
include_once(_PS_MODULE_DIR_.'paygent/paygent.php');

global $smarty;
global $cart;
$return_url = $smarty->tpl_vars['base_dir'].'history.php';
$paygent_helper = new PaygentHelper();
$paygent = new Paygent();
$paygent_helper->load_configuration();
$paygent_action = Configuration::get('PAYGENT_ACTION_URL');
$merchant_id = $paygent_helper->get_merchant_id();
$trading_id = $cart->id;
$id = $cart->getOrderTotal(true);
$customer_id = $cart->id_customer;
$payment_class = "0";
$payment_type = "02";
$use_card_conf_number = "1";
$paygent_helper->set_trading_id($trading_id);
$paygent_helper->set_payment_type($payment_type);
$paygent_helper->set_id($id);
$paygent_helper->set_customer_id($customer_id);
$paygent_helper->set_payment_class($payment_class);
$paygent_helper->set_use_card_conf_number($use_card_conf_number);
$hash = $paygent_helper->generate_hash();

$paygent_helper->insert_transaction();
// TODO special order status for paygent
$paygent->validateOrder($cart->id, 1, $id);

?>
<html>
  <head>
    <title>Paygent</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  </head>
  <body>
    <p>Please wait, redirecting to Paygent Credit Card service... Thanks.<br/>
    <a href="javascript:history.go(-1);">Cancel</a>
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
  <!--  <script type="text/javascript">$(document).ready(function(){$('#paygent_form').submit();});</script> -->
  </body>
</html>

<?php

include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../../init.php');

include_once(_PS_MODULE_DIR_.'paygent/classes/paygent.php');



?>

<html>
<head></head>
<body>
Redirecting to Paygent credit card service ...
<form method="POST" action="https://sandbox.paygent.co.jp/v/u/request">
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

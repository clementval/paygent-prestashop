<?php
include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../../init.php');
include_once(_PS_MODULE_DIR_.'paygent/classes/paygent_helper.php');

$security_token = Configuration::get('PAYGENT_SECURITY_TOKEN');

//if(isset($_GET['token']) && $_GET['token'] == $security_token) {
  $paygent_helper = new PaygentHelper();
  $trading_id = trim($_POST["trading_id"]);
  $hc = trim($_POST["hc"]);
  $acq_id = trim($_POST["acq_id"]);
  $acq_name = trim($_POST["acq_name"]);
  $payment_status = trim($_POST["payment_status"]);
  $payment_class = trim($_POST["payment_class"]);
  $payment_notice_id = trim($_POST["payment_notice_id"]);
  $payment_id = trim($_POST["payment_id"]);
  $payment_amount = trim($_POST["payment_amount"]);
  $payment_type = trim($_POST["payment_type"]);

  if($trading_id != "") {
      // Update the information in DB
      $paygent_helper->update_transaction($trading_id, $hc, $acq_id, $acq_name,
                                          $payment_status, $payment_class,
                                          $payment_notice_id, $payment_id,
                                          $payment_amount, $payment_type);

      // Update the order status
      $objOrder = new Order((int)$trading_id);
      if(((int)$payment_status) == 20) { // Authorization OK
        $objOrder->setCurrentState(2);
      } else {
        // Cancel order
        $objOrder->setCurrentState(8);
      }

      // Acknoledge the request from Paygent server
      http_response_code(200);
      echo 'result=0';
  }
/*} else {
  echo 'Unauthorized access.';
}*/
?>

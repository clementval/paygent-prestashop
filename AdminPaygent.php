<?php

class AdminPaygent extends AdminTab {

  public function __construct()
  {
    $this->table = 'paygent';
    $this->className = 'Paygent';
    $this->lang = true;
    $this->edit = true;
    $this->delete = true;
    parent::__construct();
  }

  public function display()
  {
    $token = Tools::getAdminTokenLite('AdminPaygent');
    $currentIndex = 'index.php?tab=AdminPaygent&token='.$token;
    $action_url = Configuration::get('PAYGENT_ACTION_URL');
    $merchant_id = Configuration::get('PAYGENT_MERCHANT_ID');
    $hash_key = Configuration::get('PAYGENT_HASHKEY');
    $status_waiting = Configuration::get('PAYGENT_ORDER_STATUS_WAIT');
    $status_success = Configuration::get('PAYGENT_ORDER_STATUS_SUCCESS');
    $status_error = Configuration::get('PAYGENT_ORDER_STATUS_ERROR');

    $inform_url = "";
    echo '<h2>Paygent payement configuration</h2>';
    echo '<h3>Merchant configuration</h3>';
    echo '<form name="paygent_config" action="'.$currentIndex.'" method="post">';
    echo 'Paygent Action URL: <input type="text" name="action_url" value="'.$action_url.'"/></br>';
    echo 'Merchant ID: <input type="text" name="merchant_id" value="'.$merchant_id.'"/></br>';
    echo 'Hash key: <input type="text" name="hash_key" value="'.$hash_key.'"/></br>';
    echo 'Order status (payment succeed): <input type="text" name="status_success" value="'.$status_success.'"/></br>';
    echo 'Order status (payment error): <input type="text" name="status_error" value="'.$status_error.'"/></br>';
    echo 'Order status (waiting): <input type="text" name="status_waiting" value="'.$status_waiting.'"/></br>';
    echo '<input type="submit" name="paygent_config" value="Save" />';
    echo '</form>';

    if($action_url != "" && $merchant_id != "" && $hash_key != "") {
      echo '<br><br>';
      echo '<h3>Test payment</h3>';
      echo '<form method="POST" action="'.__PS_BASE_URI__.'modules/paygent/payment/submit_test.php" id="paygent_form">';
      echo 'Customer ID: <input type="text" name="test_customer_id"/><br>';
      echo 'Amount: <input type="text" name="test_amount"/><br>';
      echo 'Trading ID: <input type="text" name="test_trading_id"/><br>';
      echo '<input type="submit" value="Test"/>';
      echo '</form>';
      echo '<br>';

      echo '<h3>Test response from Paygent</h3>';
      echo '<form method="POST" action="'.__PS_BASE_URI__.'modules/paygent/payment/confirm.php">';
      echo 'Trading ID: <input type="text" name="trading_id"/><br>';
      echo 'Acq ID: <input type="text" name="acq_id" value="50001"/><br>';
      echo 'Acq Name: <input type="text" name="acq_name" value="NICOS"/><br>';
      echo 'Hash value: <input type="text" name="hc"/><br>';
      echo 'Payment Status: <input type="text" name="payment_status" value="20"/><br>';
      echo 'Payment Class: <input type="text" name="payment_class" value="10"/><br>';
      echo 'Payment Notice ID: <input type="text" name="payment_notice_id" value="8"/><br>';
      echo 'Payment ID: <input type="text" name="payment_id"/><br>';
      echo 'Payment Amount: <input type="text" name="payment_amount"/><br>';
      echo 'Payment Type: <input type="text" name="payment_type" value="2"/><br>';
      echo '<input type="submit" value="Test"/>';
      echo '</form>';
    }
  }

  public function postProcess()
	{
    if (Tools::isSubmit('paygent_config')){
      Configuration::updateValue('PAYGENT_ACTION_URL',  Tools::getValue('action_url'));
      Configuration::updateValue('PAYGENT_MERCHANT_ID',  Tools::getValue('merchant_id'));
      Configuration::updateValue('PAYGENT_HASHKEY', Tools::getValue('hash_key'));
      Configuration::updateValue('PAYGENT_ORDER_STATUS_SUCCESS', Tools::getValue('status_success'));
      Configuration::updateValue('PAYGENT_ORDER_STATUS_ERROR', Tools::getValue('status_error'));
      Configuration::updateValue('PAYGENT_ORDER_STATUS_WAIT', Tools::getValue('status_waiting'));
    }
  }
}
?>

<?php
include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../../init.php');
include_once(_PS_MODULE_DIR_.'paygent/classes/paygent_helper.php');

$paygent = new PaygentHelper();
$trading_id = trim($_POST["trading_id"]);
$response = trim($_POST["response"]);
if($trading_id != ""){
    // Update the information in DB
    $paygent->update_transaction($trading_id, $response);

    // Update the order status
    $objOrder = new Order((int)$trading_id);
    if(((int)$response) == 0) {
      $objOrder->setCurrentState((int)Configuration::get('PAYGENT_ORDER_STATUS_SUCCESS'));
    } else {
      $objOrder->setCurrentState((int)Configuration::get('PAYGENT_ORDER_STATUS_ERROR'));
    }
}


/*
  $all_posts = "";
  foreach ($_POST as $key => $value) {
    $all_posts = $all_posts.'Field:'.htmlspecialchars($key).'//'..htmlspecialchars($value);
  }

 information in POST
 result=0 0 = SUCCESS 1 = FAILURE
 response_code=
 response_detail=
 url=https://service.paygent.co.jp/linktype/top?type=&tid=book_101121&mid=10011212&hv=MFEwMTAyMDAw
 trading_id=book_101121
 payment_type=01,02,05
 limit_date=20070707235959
 trade_generation_date=20070705121030
*/

?>

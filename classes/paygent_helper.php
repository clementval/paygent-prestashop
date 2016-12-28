<?php

include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../../init.php');

class PaygentHelper {

  private $trading_id;
  private $payment_type;
  private $fix_params;
  private $id;
  private $inform_url;
  private $merchant_id;
  private $payment_term_day;
  private $payment_term_min;
  private $payment_class;
  private $use_card_conf_number;
  private $customer_id;
  private $threedsecure_ryaku;
  private $hash_key;

  function __construct () {
    $this->trading_id = "";
    $this->payment_type = "";
    $this->fix_params = "";
    $this->id = "";
    $this->inform_url = "";
    $this->merchant_id = "";
    $this->payment_term_day = "";
    $this->payment_term_min = "";
    $this->payment_class = "";
    $this->use_card_conf_number = "";
    $this->customer_id = "";
    $this->threedsecure_ryaku = "";
    $this->hash_key = "";
  }

  function load_configuration(){
    $this->hash_key = Configuration::get('PAYGENT_HASHKEY');
    $this->merchant_id = Configuration::get('PAYGENT_MERCHANT_ID');
  }

  function generate_hash(){
    return hash('sha256', $this->get_original_str());
  }

  function get_original_str(){
    $original_str =
      $this->trading_id.
      $this->payment_type.
      $this->fix_params.
      $this->id.
      $this->inform_url.
      $this->merchant_id.
      $this->payment_term_day.
      $this->payment_term_min.
      $this->payment_class.
      $this->use_card_conf_number.
      $this->customer_id.
      $this->threedsecure_ryaku.
      $this->hash_key;
    return $original_str;
  }

  function random_hash(){
    $rand_str = "";
    $rand_char = array('a','b','c','d','e','f','A','B','C','D','E','F','0','1','2','3','4','5','6','7','8','9');
    for($i=0; ($i<20 && rand(1,10) != 10); $i++){
      $rand_str .= $rand_char[rand(0, count($rand_char)-1)];
    }
    return $rand_str;
  }

  function insert_transaction(){
    if($this->trading_id != ""){
      return Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'paygent_details` (`trading_id`, `payment_amount`, `timestamp`)
        VALUES ('.$this->trading_id.', '.$this->id.', NOW())');
    }
  }

  function update_transaction($post_trading_id, $post_hc, $post_acq_id,
                              $post_acq_name, $post_payment_status,
                              $post_payment_class, $post_payment_notice_id,
                              $post_payment_id, $post_payment_amount,
                              $post_payment_type, $order_id)
  {
    return Db::getInstance()->Execute('INSERT INTO
      `'._DB_PREFIX_.'paygent_details` (`timestamp`, `hc`, `acq_id`, `acq_name`,
      `payment_status`, `payment_class`, `payment_notice_id`, `trading_id`,
      `payment_id`, `payment_amount`, `payment_type`, `order_id`) VALUES (
        NOW(), \''.$post_hc.'\', '.$post_acq_id.', \''.$post_acq_name.'\',
        '.$post_payment_status.', '.$post_payment_class.',
        '.$post_payment_notice_id.', '.$post_trading_id.', '.$post_payment_id.',
        '.$post_payment_amount.', '.$post_payment_type.', '.$order_id.'
      )');
  }

  function set_trading_id($value){
    $this->trading_id = $value;
  }

  function set_payment_type($value){
    $this->payment_type = $value;
  }

  function set_fix_params($value){
    $this->fix_params = $value;
  }

  function set_id($value){
    $this->id = $value;
  }

  function set_inform_url($value){
    $this->inform_url = $value;
  }

  function set_merchant_id($value){
    $this->merchant_id = $value;
  }

  function get_merchant_id(){
    return $this->merchant_id;
  }

  function set_payment_term_day($value){
    $this->payment_term_day = $value;
  }

  function set_payment_term_min($value){
    $this->payment_term_min = $value;
  }

  function set_payment_class($value){
    $this->payment_class = $value;
  }

  function set_use_card_conf_number($value){
    $this->use_card_conf_number = $value;
  }

  function set_customer_id($value){
    $this->customer_id = $value;
  }

  function set_threedsecure_ryaku($value){
    $this->threedsecure_ryaku = $value;
  }

  function set_hash_key($value){
    $this->hash_key = $value;
  }
}
?>

<?php
class Paygent {

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

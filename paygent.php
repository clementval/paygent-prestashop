<?php
if (!defined('_PS_VERSION_'))
  exit;

class Paygent extends Module {
  public function __construct() {
    $this->name = 'paygent';
    $this->tab = 'Payment';
    $this->version = 1.0;
    $this->author = 'Valentin Clement';
    $this->need_instance = 0;

    parent::__construct();

    $this->displayName = $this->l('Paygent payment module');
    $this->description = $this->l('Payment module to handle transaction with Paygent credit card service.');
  }

  public function install() {
    if (parent::install() == false){
      return false;
    }
    // Do the construction work like db table creation
    return true;
  }


  public function uninstall() {
  if (!parent::uninstall()){
    // Do the cleaning work
    //Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'paygent`');
  }
  parent::uninstall();
  }
}
?>

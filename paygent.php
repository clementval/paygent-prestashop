<?php
if (!defined('_PS_VERSION_'))
  exit;

class Paygent extends Module {
  public function __construct() {
    $this->name = 'paygent';
    $this->tab = 'payments_gateways';
    $this->version = 1.0;
    $this->author = 'Valentin Clement';
    $this->need_instance = 0;

    parent::__construct();

    $this->displayName = $this->l('Paygent');
    $this->description = $this->l('Accepts payments by credit cards with Paygent.');
  }

  public function install() {
    if (parent::install() == false){
      return false;
    }

    if(self::installModuleTab('AdminPaygent', array('default' => 'Pay Systems'), 'AdminModules') == false){
      return false;
    }

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

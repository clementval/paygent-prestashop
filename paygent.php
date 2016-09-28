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

    $this->initializeDB();

    if(self::installModuleTab('AdminPaygent', array('default' => 'Pay Systems'), 'AdminModules') == false){
      return false;
    }

    return true;
  }

  public function uninstall() {
    if (!parent::uninstall()){
      $this->cleanupDB();
    }
    parent::uninstall();
  }

  // Create and populate module's tables
  private function initializeDB(){
    Db::getInstance()->Execute('CREATE TABLE `'._DB_PREFIX_.'paygent_config` (
      `id_paygent_config` INT(10) NOT NULL AUTO_INCREMENT,
      `config_key` VARCHAR(255) NOT NULL ,
      `config_value` VARCHAR(255) NOT NULL ,
      PRIMARY KEY (`id_paygent_config`))
      ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8');
  }

  // Cleanup the DB when the module is uninstalled
  private function cleanupDB(){
    Db::getInstance()->Execute('DROP TABLE `'._DB_PREFIX_.'paygent_config`');
  }
}
?>

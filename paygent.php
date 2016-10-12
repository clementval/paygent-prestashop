<?php
if (!defined('_PS_VERSION_'))
  exit;

class Paygent extends Module
{
  public function __construct()
  {
    $this->name = 'paygent';
    $this->tab = 'payments_gateways';
    $this->version = 1.0;
    $this->author = 'Valentin Clement';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.4', 'max' => '1.4');
    $this->currencies = true;
    $this->currencies_mode = 'checkbox';

    parent::__construct();

    $this->displayName = $this->l('Paygent');
    $this->description = $this->l('Accepts payments by credit cards with Paygent.');
  }

  /******************************************
   * MODULE INSTALLATION AND UNINSTALL PART *
   ******************************************/

  public function install()
  {
    if (!parent::install()){
      return false;
    }

    // Install the amdinistration tab for the back office
    if(!$this->createAdminTab()){
      return false;
    }

    // Crate the configuration table
    if(!$this->initializeDB()){
      return false;
    }

    // Populate the configuration table
    $this->insertConfiguration()

    if(!$this->registerHook('payment')){
      return false;
    }

    return true;
  }

  public function uninstall()
  {
    if (!parent::uninstall()){
      return false;
    }

    // Remove the administration tab from the back office
    if(!$this->deleteAdminTab()){
      return false;
    }

    $this->deleteConfiguration();

    // Delete the tables in the database
    if(!$this->cleanupDB()){
      return false;
    }

    return true;
  }

  /******************
   * DATABASE PART  *
   ******************/

  // Create and populate module's tables
  private function initializeDB()
  {
    /*return Db::getInstance()->Execute('CREATE TABLE `'._DB_PREFIX_.'paygent_config` (
      `id_paygent_config` INT(10) NOT NULL AUTO_INCREMENT,
      `config_key` VARCHAR(255) NOT NULL ,
      `config_value` VARCHAR(255) NOT NULL ,
      PRIMARY KEY (`id_paygent_config`)
      ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8');*/
  }

  // Insert keys for the configuration
  private function insertConfiguration()
  {
    Configuration::updateValue('PAYGENT_HASHKEY', '');
    Configuration::updateValue('PAYGENT_MERCHANT_ID', '');
    /*return Db::getInstance()->Execute("INSERT INTO `"._DB_PREFIX_."paygent_config` (`config_key`, `config_value`)
      VALUES ('HASH_KEY', ''),
      ('MERCHANT_ID', '')"
    );*/
  }

  // Delete the configuration keys
  private function deleteConfiguration(){
    Configuration::deleteByName('PAYGENT_HASHKEY');
    Configuration::deleteByName('PAYGENT_MERCHANT_ID');
  }

  // Cleanup the DB when the module is uninstalled
  private function cleanupDB()
  {
    //return Db::getInstance()->Execute('DROP TABLE `'._DB_PREFIX_.'paygent_config`');
  }


  /******************
   * ADMIN TAB PART *
   ******************/

  private function createAdminTab()
  {
    $langs = Language::getLanguages();
    $id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
    $admin_tab = new Tab();
    $admin_tab->class_name = 'AdminPaygent';
    $admin_tab->module = 'paygent';
    $admin_tab->id_parent = 0;
    foreach($langs as $l){
      $admin_tab->name[$l['id_lang']] = $this->l('Paygent');
    }
    $admin_tab->save();
    $tab_id = $admin_tab->id;
    @copy(dirname(__FILE__).'/logo.gif',_PS_ROOT_DIR_.'/img/t/logo.gif');
    Configuration::updateValue('PAYGENT_TAB_ID', $tab_id);
    return true;
  }

  public function deleteAdminTab()
  {
    $admin_tab = new Tab(Configuration::get('PAYGENT_TAB_ID'));
    $admin_tab->delete();
    Configuration::deleteByName('PAYGENT_TAB_ID');
    return true;
  }

}
?>

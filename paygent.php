<?php
if (!defined('_PS_VERSION_'))
  exit;

class Paygent extends PaymentModule
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
    $this->insertConfiguration();

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
    return Db::getInstance()->Execute('CREATE TABLE `'._DB_PREFIX_.'paygent_details (
      `id_paygent_details` INT NOT NULL AUTO_INCREMENT ,
      `id_order` INT NOT NULL , `amount` INT NOT NULL ,
      `response` INT NULL ,
      `timestamp_sent` DATETIME NOT NULL ,
      `timestamp_response` DATETIME NULL ,
      PRIMARY KEY (`id_paygent_details`))
      ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8');
  }

  // Insert keys for the configuration
  private function insertConfiguration()
  {
    Configuration::updateValue('PAYGENT_ACTION_URL', '');
    Configuration::updateValue('PAYGENT_HASHKEY', '');
    Configuration::updateValue('PAYGENT_MERCHANT_ID', '');
    return true;
  }

  // Delete the configuration keys
  private function deleteConfiguration(){
    Configuration::deleteByName('PAYGENT_ACTION_URL');
    Configuration::deleteByName('PAYGENT_HASHKEY');
    Configuration::deleteByName('PAYGENT_MERCHANT_ID');
    return true;
  }

  // Cleanup the DB when the module is uninstalled
  private function cleanupDB()
  {
    return Db::getInstance()->Execute('DROP TABLE `'._DB_PREFIX_.'paygent_details`');
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

  /******************
   * HOOK PART *
   ******************/

  public function hookPaymentReturn()
  {
    if (!$this->active) {
      return null;
    }
    return $this->fetchTemplate('confirmation.tpl');
  }

  public function hookPayment($params)
  {
    if (!$this->active) {
        return null;
    }
    return $this->fetchTemplate('payment.tpl');
  }

  public function fetchTemplate($name)
  {
    if (version_compare(_PS_VERSION_, '1.4', '<')) {
      $this->context->smarty->currentTemplate = $name;
    } elseif (version_compare(_PS_VERSION_, '1.5', '<')) {
      $views = 'views/templates/';
      if (@filemtime(dirname(__FILE__).'/'.$name)) {
        return $this->display(__FILE__, $name);
      } elseif (@filemtime(dirname(__FILE__).'/'.$views.'hook/'.$name)) {
        return $this->display(__FILE__, $views.'hook/'.$name);
      } elseif (@filemtime(dirname(__FILE__).'/'.$views.'front/'.$name)) {
        return $this->display(__FILE__, $views.'front/'.$name);
      } elseif (@filemtime(dirname(__FILE__).'/'.$views.'admin/'.$name)) {
        return $this->display(__FILE__, $views.'admin/'.$name);
      }
    }
    return $this->display(__FILE__, $name);
  }

  public function validateOrder($id_cart, $id_order_state, $amount_paid) {
    if($this->active){
      parent::validateOrder(
        (int) $id_cart,
        (int) $id_order_state,
        (float) $amount_paid,
        'Paygent'
      );
    }
  }



}
?>

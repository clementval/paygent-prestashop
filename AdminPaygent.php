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
    $merchant_id = Configuration::get('PAYGENT_MERCHANT_ID');
    $hash_key = Configuration::get('PAYGENT_HASHKEY');
    $inform_url = "";
    echo '<h2>Paygent payement configuration</h2>';
    echo '<form name="paygent_config" action="'.$currentIndex.'" method="post">';
    echo 'Merchant ID: <input type="text" name="merchant_id" value="'.$merchant_id.'"/></br>';
    echo 'Hash key: <input type="text" name="hash_key" value="'.$hash_key.'"/></br>';
    echo '<input type="submit" name="paygent_config" value="Save" />';
    echo '</form>';
  }

  public function postProcess()
	{
    if (Tools::isSubmit('paygent_config')){
      Configuration::updateValue('PAYGENT_MERCHANT_ID',  Tools::getValue('merchant_id'));
      Configuration::updateValue('PAYGENT_HASHKEY', Tools::getValue('hash_key'));
    }
  }
}
?>

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
    $sql = 'SELECT * FROM '._DB_PREFIX_.'paygent_config';
    if ($results = Db::getInstance()->ExecuteS($sql)){
      $merchant_id = Configuration::get('PAYGENT_MERCHANT_ID');
      $hash_key = Configuration::get('PAYGENT_HASHKEY');
      $inform_url = "";
      echo "<h2>Paygent payement configuration</h2>";
      echo "<form>";
      echo "Merchant ID: <input type='text' name='merchant_id' value='".$merchant_id."'/></br>";
      echo "Hash key: <input type='text' name='hash_key' value='".$hash_key."'/></br>";
      echo "Inform URL: <input type='text' name='inform_url' value='".$inform_url."'/></br>";
      echo "<input type='submit' value='Save'/>";
      echo "</form>";
    } else {
      echo "<h2>Error: Cannot retrieve Paygent configuration from DB.</h2>";
    }
  }
}
?>

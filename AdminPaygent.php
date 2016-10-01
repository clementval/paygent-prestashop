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
      $merchant_id = "";
      $hash_key = "";
      $inform_url = "";
      foreach ($results as $row){
        switch ($row['config_key']) {
          case 'HASH_KEY':
              $hash_key = $row['config_value'];
              break;
          case 'MERCHANT_ID':
              $merchant_id = $row['config_value'];
              break;
          case 'INFORM_URL':
              $inform_url =  $row['config_value'];
              break;
          default:
            echo 'Unknow key: '.$row['config_key'];
        }
      }
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

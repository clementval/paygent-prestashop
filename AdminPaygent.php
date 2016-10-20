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

    if (Tools::isSubmit('paygent_config')){
      echo 'Saved';
    } else {
      $merchant_id = Configuration::get('PAYGENT_MERCHANT_ID');
      $hash_key = Configuration::get('PAYGENT_HASHKEY');
      $inform_url = "";
      echo "<h2>Paygent payement configuration</h2>";

//      <form action="' . $currentIndex . '&submitAdd' .  $this->table . '=1&token=' . $this->token . '" method="post" >
      echo '<form name="paygent_config" action="'.$currentIndex.'" method="post">';
      echo "Merchant ID: <input type='text' name='merchant_id' value='".$merchant_id."'/></br>";
      echo "Hash key: <input type='text' name='hash_key' value='".$hash_key."'/></br>";
      echo "Inform URL: <input type='text' name='inform_url' value='".$inform_url."'/></br>";
      echo "<input type='submit' value='Save'/>";
      echo "</form>";
    }
  }
}
?>

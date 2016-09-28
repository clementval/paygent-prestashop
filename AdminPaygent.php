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
    echo "<h2>Paygent payement configuration</h2>";
    echo "<form>";
    echo "Merchant ID: <input type='text' name='merchant_id' value=''/></br>";
    echo "Hash key: <input type='text' name='hash_key' value=''/></br>";
    echo "<input type='submit' value='Save'/>"
    echo "</form>";
  }
}
?>

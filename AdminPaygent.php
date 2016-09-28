<?php
class AdminPaygent extends AdminTab {
	public function __construct(){
	 	$this->table = 'paygent';
	 	$this->className = 'Paygent';
		$this->lang = true;
		$this->edit = true;
		$this->delete = true;

		parent::__construct();
	}

	public function displayForm($isMainTab = true) {
		global $currentIndex, $cookie;
		parent::displayForm();
		if (!($obj = $this->loadObject(true)))
			return;

    echo '<h2>Paygent payement configuration</h2>';
	}
}
?>

<?php

class AdminPaygentController extends ModuleAdminController
{
  public function __construct()
  {
    $token = Tools::getAdminTokenLite('AdminModules');
    $currentIndex = 'index.php?controller=AdminModules&token='.$token.'&configure=paygent&tab_module=front_office_features&module_name=paygent';
    parent::__construct();
    Tools::redirectAdmin($currentIndex);
  }
}
?>

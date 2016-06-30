<?php
namespace Application\Controller;

use Application\Controller\getSkillsTable;

class getWeponsTable extends getSkillsTable{
  public function getWeponsTable(){
    if(!$this->weponsTable){
      $sm = $this->getServiceLocator();
      $this->weponsTable = $sm->get('Application\Model\WeponsTable');
    }
    return $this->weponsTable;
  }
}

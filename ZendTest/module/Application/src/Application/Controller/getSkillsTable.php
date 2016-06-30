<?php
namespace Application\Controller;

use Application\Controller\getTypesTable;

class getSkillsTable extends getTypesTable{
  public function getSkillsTable(){
    if(!$this->skillsTable){
      $sm = $this->getServiceLocator();
      $this->skillsTable = $sm->get('Application\Model\SkillsTable');
    }
    return $this->skillsTable;
  }
}

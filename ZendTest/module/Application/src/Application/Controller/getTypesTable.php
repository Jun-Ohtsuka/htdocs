<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class getTypesTable extends AbstractActionController{
  public function getTypesTable(){
    if(!$this->typesTable){
      $sm = $this->getServiceLocator();
      $this->typesTable = $sm->get('Application\Model\TypesTable');
    }
    return $this->typesTable;
  }
}

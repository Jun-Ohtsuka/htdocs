<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TestController extends AbstractActionController{
  public function indexAction(){
    echo "test/index";
    return new ViewModel();
  }
}

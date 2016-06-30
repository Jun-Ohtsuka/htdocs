<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AddController extends AbstractActionController{
  public function indexAction(){
    $flashMessenger = $this->flashMessenger();
    if($flashMessenger->hasMessages()){
      $messages = $flashMessenger->getMessages();
      $view = new ViewModel(array('messages' => $messages));
      return $view;
    }
    echo "add/index";
    return new ViewModel();
  }

  public function insertAction(){
    $name = $this->params()->fromPost('name');
    $this->flashMessenger()->addMessage($name);

    return $this->redirect()->toUrl('/add');
  }
}

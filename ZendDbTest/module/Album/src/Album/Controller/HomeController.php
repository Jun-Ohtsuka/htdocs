<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractActionController{

  protected $albumTable;

  public function indexAction(){
    $albums = $this->getAlbumTable()->fetchAll();
    $albums->buffer();
    $view = new ViewModel(array('albums' => $albums));
    return $view;
  }

  public function getAlbumTable(){
    if(!$this->albumTable){
      $sm = $this->getServiceLocator();
      $this->albumTable = $sm->get('Album\Model\AlbumTable');
    }
    return $this->albumTable;
  }
}

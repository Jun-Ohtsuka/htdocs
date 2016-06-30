<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Wepon;
use Application\Controller\getWeponsTable;
use My\Validators;

class WeponController extends getWeponsTable{

  protected $weponsTable;
  protected $typesTable;
  protected $skillsTable;

  public function indexAction(){
    $wepons = $this->getWeponsTable()->fetchAll();
    $wepons->buffer();
    $types = $this->getTypesTable()->fetchAll();
    $types->buffer();
    $typeArray = array();
    foreach($types as $type){
      $typeArray["{$type->id}"] = $type->name;
    }
    $skills = $this->getSkillsTable()->fetchAll();
    $skills->buffer();
    $skillArray = array();
    foreach($skills as $skill){
      $skillArray["{$skill->id}"] = $skill->name;
    }
    return new ViewModel(array(
      'wepons' => $wepons,
      'types' => $typeArray,
      'skills' => $skillArray,
    ));
  }

  public function deleteAction(){
    $id = $this->params()->fromPost('id');
    $this->getWeponsTable()->deleteWepon($id);

    return $this->redirect()->toUrl('/');
  }


  public function newWeponAction(){
    $flashMessenger = $this->flashMessenger();
    $types = $this->getTypesTable()->fetchAll();
    $types->buffer();
    $skills = $this->getSkillsTable()->fetchAll();
    $skills->buffer();

    if($flashMessenger->hasMessages()){
      $errorMessages = $flashMessenger->getMessages();
      return new ViewModel(array(
        'messages' => $errorMessages,
        'types' => $types,
        'skills' => $skills,
        'skill_id1' => $this->params()->fromQuery('skill_id1'),
        'skill_id2' => $this->params()->fromQuery('skill_id2'),
        'type_id' => $this->params()->fromQuery('type_id'),
        'hp' => $this->params()->fromQuery('hp'),
        'atk' => $this->params()->fromQuery('atk'),
        'name' => $this->params()->fromQuery('name'),
        'skill_level' => $this->params()->fromQuery('skill_level'),
      ));
    }

    $view = new ViewModel(array(
      'types' => $types,
      'skills' => $skills,
      'skill_id1' => 0,
      'skill_id2' => 0,
      'type_id' => 1,
      'hp' => 1,
      'atk' => 1,
      'name' => '',
      'skill_level' => 0,
    ));

    return $view;
  }

  public function insertAction(){
    $wepon = new Wepon();
    $wepon->name = $this->params()->fromPost('name');
    $wepon->hp = $this->params()->fromPost('hp');
    $wepon->atk = $this->params()->fromPost('atk');
    $wepon->type_id = $this->params()->fromPost('type_id');
    $wepon->skill_id1 = $this->params()->fromPost('skill_id1');
    $wepon->skill_id2 = $this->params()->fromPost('skill_id2');
    $wepon->skill_level = $this->params()->fromPost('skill_level');

    $valid = new Validators();
    $messages = $valid->valid($wepon);

    if(count($messages) > 0){
      foreach($messages as $message){
        $this->flashMessenger()->addMessage($message);
      }

      return $this->redirect()->toRoute(
        'wepon',
        [
          'controller'  => 'wepon',
          'action'      => 'newwepon'
        ],
        [
          'query' => [
            'name'        => $wepon->name,
            'hp'          => $wepon->hp,
            'atk'         => $wepon->atk,
            'skill_id1'   => $wepon->skill_id1,
            'skill_id2'   => $wepon->skill_id2,
            'skill_level' => $wepon->skill_level,
            'type_id'     => $wepon->type_id,
          ]
        ]
      );
    }else{

      $this->getWeponsTable()->saveWepon($wepon);
      return $this->redirect()->toUrl('/');
    }
  }

  public function settingAction(){
    $id = $this->params()->fromQuery('id');
    $wepon = $this->getWeponsTable()->getWepon($id);
    $types = $this->getTypesTable()->fetchAll();
    $types->buffer();
    $skills = $this->getSkillsTable()->fetchAll();
    $skills->buffer();
    return new ViewModel(array(
      'id'          => $id,
      'types'       => $types,
      'skills'      => $skills,
      'skill_id1'   => $wepon->skill_id1,
      'skill_id2'   => $wepon->skill_id2,
      'type_id'     => $wepon->type_id,
      'hp'          => $wepon->hp,
      'atk'         => $wepon->atk,
      'name'        => $wepon->name,
      'skill_level' => $wepon->skill_level,
    ));
  }

  public function updateAction(){
    $wepon = new Wepon();
    $wepon->id = $this->params()->fromPost('id');
    $wepon->name = $this->params()->fromPost('name');
    $wepon->hp = $this->params()->fromPost('hp');
    $wepon->atk = $this->params()->fromPost('atk');
    $wepon->type_id = $this->params()->fromPost('type_id');
    $wepon->skill_id1 = $this->params()->fromPost('skill_id1');
    $wepon->skill_id2 = $this->params()->fromPost('skill_id2');
    $wepon->skill_level = $this->params()->fromPost('skill_level');

    $this->getWeponsTable()->saveWepon($wepon);

    return $this->redirect()->toUrl('/');
  }
}

<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\HomeModel;
use Application\Controller\getWeponsTable;

class HomeController extends getWeponsTable{

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

  public function getWeponAction(){
    header('Content-Type: application/json');

    $id = $this->params()->fromQuery('id');
    echo $id;

    $wepon = $this->getWeponsTable()->getWepon($id);
    $wepon->buffer();
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

    $data = array(
      '<td class="data">'.$typeArray["{$wepon->type_id}"].'</td>
      <td class="data">'.$wepon->hp.'</td>
      <td class="data">'.$wepon->atk.'</td>
      <td class="data">'.$skillArray["{$wepon->skill_id1}"].'</td>
      <td class="data">'.$skillArray["{$wepon->skill_id2}"].'</td>
      <td class="data">'.$wepon->skill_level.'</td>'
    );

    echo json_encode($data);
  }
}

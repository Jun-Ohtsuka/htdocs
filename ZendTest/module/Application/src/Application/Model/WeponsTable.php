<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class WeponsTable extends TableGateway{
  protected $tableGateway;

  public function __construct(TableGateway $tableGateway){
    $this->tableGateway = $tableGateway;
  }

  public function fetchAll(){
    $resultSet = $this->tableGateway->select();
    return $resultSet;
  }

  public function getWepon($id){
    $id  = (int) $id;
    $rowset = $this->tableGateway->select(array('id' => $id));
    $row = $rowset->current();
    if (!$row) {
      throw new \Exception("Could not find row {$id}");
    }
    return $row;
  }

  public function saveWepon(Wepon $wepon){
    $data = array(
    'name' => $wepon->name,
    'hp'  => $wepon->hp,
    'atk'  => $wepon->atk,
    'skill_id1'  => $wepon->skill_id1,
    'skill_id2'  => $wepon->skill_id2,
    'skill_level'  => $wepon->skill_level,
    'type_id'  => $wepon->type_id,
  );

    $id = (int)$wepon->id;
    if ($id == 0) {
      $this->tableGateway->insert($data);
    } else {
      if ($this->getWepon($id)) {
        $this->tableGateway->update($data, array('id' => $id));
      } else {
        throw new \Exception('Form id does not exist');
      }
    }
  }

  public function deleteWepon($id){
    $this->tableGateway->delete(array('id' => $id));
  }
}

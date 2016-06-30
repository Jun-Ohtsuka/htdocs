<?php

class PositionRepository extends DbRepository{

  public function getPosition(){
    $sql="SELECT * FROM positions";
    $stmt = $this->selectAll($sql);
    return $stmt;
  }
}

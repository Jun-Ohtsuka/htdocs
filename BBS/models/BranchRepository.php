<?php

class BranchRepository extends DbRepository{

  public function getBranch(){
    $sql="SELECT * FROM branchs";
    $stmt = $this->selectAll($sql);
    return $stmt;
  }
}

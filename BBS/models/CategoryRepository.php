<?php

class CategoryRepository extends DbRepository{

  public function getCategory(){
    $sql="SELECT DISTINCT category FROM threads";
    $stmt = $this->selectAll($sql);
    return $stmt;
  }
}

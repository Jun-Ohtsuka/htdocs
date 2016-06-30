<?php

class Position{

  require('OpenDb.php');

  public function getPosition(){
    try{
    	$stmt = $db->query("SELECT * FROM positions");
    	$position = $stmt->fetchAll(PDO::FETCH_CLASS, 'Position');

    	return $position;

    }catch(PDOException $e){
    	echo $e->getMessage();
    };
  }
}

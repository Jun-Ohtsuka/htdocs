<?php

try{
  class Category{};

	$stmt = $db->query("SELECT DISTINCT category FROM threads");
	$categorys = $stmt->fetchAll(PDO::FETCH_CLASS,'Category');

	return $categorys;

}catch(PDOException $e){
	echo $e->getMessage();
};

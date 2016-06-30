<?php

try{
	class ThreadsUsers{};

	$stmt = $db->query("select * from threads_users ORDER BY insert_date DESC");
	$threads = $stmt->fetchAll(PDO::FETCH_CLASS, 'ThreadsUsers');

	return $threads;

}catch(PDOException $e){
	echo $e->getMessage();
}

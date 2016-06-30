<?php
try{
	class CommentsUsers{}

	$stmt = $db->query("SELECT * FROM comments_users ORDER BY insert_date DESC");
	$comments = $stmt->fetchAll(PDO::FETCH_CLASS, 'CommentsUsers');

	return $comments;

}catch(PDOException $e){
	echo $e->getMessage();
}

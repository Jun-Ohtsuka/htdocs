<?php
session_start();
try{
  echo "php";
  exit;

  $title = $_POST['title'];
  $categoryType = $_POST['inputCategoryType'];
  if($categoryType == 0){
    $category = $_POST['categorySelect'];
  }else{
    $category = $_POST['categoryText'];
  }
  $text = $_POST['text'];
  $user = $_SESSION['loginUser'];
  $userId = $user['id'];
  //$time = $_POST['time'];
  $time = date('Y-m-d H:i:s');

  $error = array();
  if(isset($_POST['title'])){

  }

  $stmt = $db->prepare("INSERT INTO threads (title, category, text, user_id, insert_date, update_date) value (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$title, $category, $text, $userId, $time, $time]);

  header('Location: http://localhost/BBS/');

}catch(PDOException $e){
	echo $e->getMessage();
};

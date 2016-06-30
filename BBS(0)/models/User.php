<?php

class User {
  public function login($account, $password){
    try{

      $stmt = $db->prepare("SELECT * FROM users WHERE account = :account AND password = :password");
      $stmt->execute(':account'=>$account, ':password'=>$password) ;
      $users = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');

      foreach($users as $value){
        $user = array(
          'name'=>$value->name,
          'account'=>$value->account,
          'id'=>$value->id
        );
      }
    }catch(PDOException $e){
      echo $e->getMessage();
    }
    $_SESSION["loginUser"] = $user;
  }

  public function hashPassword($password){
    return sha1($password .'awsdfghj');
  }
}

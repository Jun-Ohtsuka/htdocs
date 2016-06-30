<?php

class UserRepository extends DbRepository{

  public function insert($account, $user_name, $password, $branch_id, $position_id){
    $password = $this->hashPassword($password);
    $now = new DateTime();

    $sql="INSERT INTO users(account, name, password, branch_id, position_id, insert_date)
      VALUES (:account, :name, :password, :branch_id, :position_id, :insert_date)";

      $stmt = $this->execute($sql, array(
        ':account'      => $account,
        ':name'         => $user_name,
        ':password'     => $password,
        ':position_id'  => $position_id,
        ':branch_id'    => $branch_id,
        ':insert_date'  => $now->format('Y-m-d H:i:s')
      ));
  }

  public function update($account, $user_name, $password, $branch_id, $position_id, $user_id){

    $now = new DateTime();
    if(!empty($password)){
      $password = $this->hashPassword($password);

      $sql="UPDATE users SET account=:account, name=:name, branch_id=:branch_id, position_id=:position_id, update_date=:update_date, password=:password
        WHERE id=:user_id";

      $stmt = $this->execute($sql, array(
        ':user_id'      => $user_id,
        ':account'      => $account,
        ':name'         => $user_name,
        ':password'     => $password,
        ':position_id'  => $position_id,
        ':branch_id'    => $branch_id,
        ':update_date'  => $now->format('Y-m-d H:i:s')
      ));
    }else{
      $sql="UPDATE users SET account=:account, name=:name, branch_id=:branch_id, position_id=:position_id, update_date=:update_date
        WHERE id=:user_id";

      $stmt = $this->execute($sql, array(
        ':user_id'      => $user_id,
        ':account'      => $account,
        ':name'         => $user_name,
        ':position_id'  => $position_id,
        ':branch_id'    => $branch_id,
        ':update_date'  => $now->format('Y-m-d H:i:s')
      ));
    }
  }

  public function hashPassword($password){
    return sha1($password .'awsdfghj');
  }

  public function fetchByUserName($account){
    $sql = "SELECT * FROM users WHERE account = :account";

    return $this->fetch($sql, array(':account' => $account));
  }

  public function isUniqueUserName($account, $user_id){
    $sql = "SELECT * FROM users WHERE account = :account";

    $row = $this->fetch($sql, array(':account' => $account));

    if(empty($row)){
      return true;
    }else if($row['id'] == $user_id){
      return true;
    }
    return false;
  }

  public function getUsers(){
    $sql = "SELECT * FROM user_view";

    return $this->selectAll($sql);
  }

  public function getUserById($user_id){
    $sql = "SELECT * FROM users WHERE id = :user_id";

    return $this->fetch($sql, array(':user_id' => $user_id));
  }

  public function freeze($user_id, $freeze){
    switch ($freeze) {
      case '0':
        $freeze = 1;
        break;

      default:
        $freeze = 0;
        break;
    }

    $sql = "UPDATE users SET freeze = :freeze WHERE id = :user_id";
    $this->execute($sql, array(':freeze' => $freeze, ':user_id' => $user_id));
  }

  public function delete($user_id){
    $sql = "DELETE FROM users WHERE id = :user_id";
    $this->execute($sql, array(':user_id' => $user_id));
  }
}

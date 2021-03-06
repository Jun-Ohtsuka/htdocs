<?php

class HomeRepository extends DbRepository{

  public function insert($user_id, $body){
    $now = new DateTime();

    $sql = "INSERT INTO status(user_id, body, insert_date)
    VALUES(:user_id, :body, :insert_date)";

    $stmt = $this->execute($sql, array(
      ':user_id'      => $user_id,
      ':body'         => $body,
      ':insert_date'  => $now->format('Y-m-d H:i:s')
    ));
  }

  public function fetchAllByUserId($user_id){
    $sql = "SELECT a.*, u.user_name
      FROM status a
        LEFT JOIN users u ON a.user_id = u.id
      WHERE u.id = :user_id
      ORDER BY a.insert_date DESC";

      return $this->fetchAll($sql, array(':user_id' => $user_id));
  }

  public function fetchByIdAndUserName($id, $user_name){
    $sql = "SELECT a.*, u.user_name
      FROM status a
        LEFT JOIN users u ON u.id = a.user_id
      WHERE a.id = :id
        AND u.user_name = :user_name";

      return $this->fetch($sql, array(
        ':id'         => $id,
        ':user_name'  => $user_name
      ));
  }
}

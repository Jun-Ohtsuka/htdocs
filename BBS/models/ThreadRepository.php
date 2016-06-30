<?php

class ThreadRepository extends DbRepository{
  public function fetchAllThread($searchStartTime, $searchEndTime, $category){
    if($category === 'category'){
      $sql = "SELECT * From threads_users WHERE insert_date >= :searchStartTime AND insert_date <= :searchEndTime ORDER BY insert_date DESC";
      $stmt = $this->fetchAll($sql, array(':searchStartTime' => $searchStartTime, ':searchEndTime' => $searchEndTime));
    }else{
      $sql = "SELECT * From threads_users WHERE category = :category AND insert_date >= :searchStartTime AND insert_date <= :searchEndTime ORDER BY insert_date DESC";
      $stmt = $this->fetchAll($sql, array(':searchStartTime' => $searchStartTime, ':searchEndTime' => $searchEndTime, ':category' => $category));
    }




    return $stmt;
  }

  public function insert($user_id, $title, $category, $text){
    $now = new DateTime();

    $sql="INSERT INTO threads(user_id, title, category, text, insert_date)
      VALUES (:user_id, :title, :category, :text, :insert_date)";

    $stmt = $this->execute($sql, array(
      ':user_id'      => $user_id,
      ':title'        => $title,
      ':category'     => $category,
      ':text'         => $text,
      ':insert_date'  => $now->format('Y-m-d H:i:s')
    ));
  }

  public function delete($thread_id){
    $sql = "DELETE FROM threads WHERE id = :thread_id";
    $this->execute($sql, array(':thread_id' => $thread_id));
  }

  public function getStartTime(){
    $sql = "SELECT insert_date From threads ORDER BY insert_date ASC LIMIT 1";
    $stmt = $this->select($sql);

    return $stmt;
  }

  public function getEndTime(){
    $sql = "SELECT insert_date From threads ORDER BY insert_date DESC LIMIT 1";
    $stmt = $this->select($sql);

    return $stmt;
  }
}

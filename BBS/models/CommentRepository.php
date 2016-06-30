<?php

class CommentRepository extends DbRepository{
  public function fetchAllComment(){
    $sql = "SELECT * FROM comments_users ORDER BY insert_date";
    $stmt = $this->selectAll($sql);

    return $stmt;
  }

  public function insert($user_id, $text, $thread_id){
    $now = new DateTime();

    $sql="INSERT INTO comments(user_id, thread_id, text, insert_date)
      VALUES (:user_id, :thread_id, :text, :insert_date)";

      $stmt = $this->execute($sql, array(
        ':user_id'      => $user_id,
        ':thread_id'    => $thread_id,
        ':text'         => $text,
        ':insert_date'  => $now->format('Y-m-d H:i:s')
      ));
  }

  public function delete($comment_id){
    $sql = "DELETE FROM comments WHERE id = :comment_id";
    $this->execute($sql, array(':comment_id' => $comment_id));
  }
}

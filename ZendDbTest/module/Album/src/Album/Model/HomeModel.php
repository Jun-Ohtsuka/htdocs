<?php
class HomeModel{
  protected function ORM(){
    require_once '/idiorm.php';
    ORM::configure('mysql:dbhost=localhost;dbname=php_db');
    ORM::configure('username', 'root');
    ORM::configure('password', 'artonelico');
  }

  public function getUsers(){
    ORM();
    $users = ORM::for_table('users')
    ->find_array();

    return $users;
  }
}

<?php
class WeponRepository{
  public function ORM(){
    require_once '../idiorm.php';
    ORM::configure('mysql:dbhost=localhost;dbname=granblue');
    ORM::configure('username', 'root');
    ORM::configure('password', 'artonelico');
  }

  public function insertWepon($add_wepon){
    $this->ORM();
    $wepon = ORM::for_table('wepons')->create();
    $wepon->set($add_wepon);
    $wepon->save();
  }

  public function updateWepon($add_wepon, $id){
    $this->ORM();
    $wepon = ORM::for_table('wepons')->find_one($id);
    $wepon->set($add_wepon);
    $wepon->save();
  }

  public function deleteWepon($id){
    $this->ORM();
    $wepon = ORM::for_table('wepons')->find_one($id);
    $wepon->delete();
  }
}

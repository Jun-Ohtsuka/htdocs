<?php

class LoginChecker extends Controller{
  public function loginCheck(){
    session_start();
    if(!isset($_SESSION["loginUser"])){
      $this->redirect('/signin.php');
    }
  }
}

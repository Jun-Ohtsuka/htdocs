<?php

class LoginController extends Controller{

  public function doPost(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    	 //ユーザーに入力してもらうデータ
    	$account = (string)$_POST['account'];
    	$password = (string)$_POST['password'];

      if(!strlen($account)){
        $errors[] = "ログインIDを入力してください";
      }else if(!preg_match('/^[[:alnum:]]{6,20}$/', $account)){
        $errors[] = "ログインIDは半角英数字を6~20文字で入力してください";
      }

      if(!strlen($password)){
        $errors[] = "パスワードを入力してください";
      }else if(6 > strlen($password) || strlen($password) > 30){
        $errors[] = "パスワードは6~30文字で入力してください";
      }

      if(count($errors) === 0){
        $password = $this->hashPassword($password);
        $login = new User();
        $login->login($account, $password);

        return $this->redirect('/');
      }
    }
  }
}

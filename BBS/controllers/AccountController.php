<?php
class AccountController extends Controller{

  protected $auth_actions = array('index', 'signout', 'freeze', 'setting', 'delete');

  public function signupAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }
    $this->positionFilter();

    $branchs = $this->db_manager->get('Branch')->getBranch();
    $positions = $this->db_manager->get('Position')->getPosition();

    return $this->render(array(
      'user_name'   => '',
      'account'     => '',
      'branchs'     => $branchs,
      'positions'   => $positions,
      'branch_id'   => '',
      'position_id' => '',
      '_token'      => $this->generateCsrfToken('account/signup')
    ));
  }

  public function registerAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }

    if(!$this->request->isPost()){
      $this->forward404();
    }

    $token = $this->request->getPost('_token');
    if(!$this->checkCsrfToken('account/signup', $token)){
      return $this->redirect('/account/signup');
    }

    $user_name = $this->request->getPost('user_name');
    $account = $this->request->getPost('account');
    $password = $this->request->getPost('password');
    $checkPassword = $this->request->getPost('checkPassword');
    $branch_id = $this->request->getPost('branch_id');
    $position_id = $this->request->getPost('position_id');
    $user_id = "0";

    $errors = array();

    if(!strlen($account)){
      $errors[] = "ログインIDを入力してください";
    }else if(!preg_match('/^[[:alnum:]]{6,20}$/', $account)){
      $errors[] = "ログインIDは半角英数字を6~20文字で入力してください";
    }else if(!$this->db_manager->get('User')->isUniqueUserName($account, $user_id)){
      $errors[] = "ログインIDは既に使用されています";
    }

    if(!strlen($password)){
      $errors[] = "パスワードを入力してください";
    }else if(6 > strlen($password) || strlen($password) > 30){
      $errors[] = "パスワードは6~30文字で入力してください";
    }

    if(!strlen($checkPassword)){
      $errors[] = "確認用パスワードを入力してください";
    }else if($password !== $checkPassword){
      $error[] = "パスワードが一致しません";
    }

    if(!strlen($user_name)){
      $errors[] = "名前を入力してください";
    }else if(mb_strlen($user_name, 'utf8') > 10){
      $errors[] = "名前は10文字で入力してください";
    }

    if(count($errors) === 0){
      $this->db_manager->get('User')->insert($account, $user_name, $password, $branch_id, $position_id);

      return $this->redirect('/account');
    }

    $branchs = $this->db_manager->get('Branch')->getBranch();
    $positions = $this->db_manager->get('Position')->getPosition();

    return $this->render(array(
      'account'     => $account,
      'user_name'   => $user_name,
      'errors'      => $errors,
      'branchs'     => $branchs,
      'positions'   => $positions,
      'branch_id'   => $branch_id,
      'position_id' => $position_id,
      '_token'      => $this->generateCsrfToken('account/signup')
    ), 'signup');
  }

  public function signinAction(){
    if($this->session->isAuthenticated()){
      return $this->redirect('/');
    }
    return $this->render(array(
      'account'   => '',
      '_token'    => $this->generateCsrfToken('account/signin')
    ));
  }

  public function authenticateAction(){
    if($this->session->isAuthenticated()){
      return $this->redirect('/');
    }

    if(!$this->request->isPost()){
      $this->forward404();
    }

    $token = $this->request->getPost('_token');
    if(!$this->checkCsrfToken('account/signin', $token)){
      return $this->redirect('/account/signin');
    }

    $account = $this->request->getPost('account');
    $password = $this->request->getPost('password');

    $errors = array();

    if(!strlen($account)){
      $errors[] = "ログインIDを入力してください";
    }

    if(!strlen($password)){
      $errors[] = "パスワードを入力してください";
    }

    if(count($errors) === 0){
      $user_repository = $this->db_manager->get('User');
      $user = $user_repository->fetchByUserName($account);

      if(!$user || ($user['password'] !== $user_repository->hashPassword($password))){
        $errors[] = 'ログインに失敗しました';
      }else{
        $this->session->setAuthenticated(true);
        $this->session->set('loginUser', $user);

        if($this->freezeCheck()){
          $errors[] = 'アカウントが停止されています';
        }else{
          return $this->redirect('/');
        }
      }
    }

    return $this->render(array(
      'account'   => $account,
      'errors'    => $errors,
      '_token'    => $this->generateCsrfToken('account/signin'),
    ),'signin');
  }

  public function signoutAction(){
    $this->session->clear();
    $this->session->setAuthenticated(false);

    return $this->redirect('/account/signin');
  }

  public function settingAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }
    $this->positionFilter();

    $user_id = $this->request->getGet('id');
    $branchs = $this->db_manager->get('Branch')->getBranch();
    $positions = $this->db_manager->get('Position')->getPosition();

    $editedUser = $this->db_manager->get('User')->getUserById($user_id);

    if(empty($editedUser)){
      $errors = array('不正なIDが入力されました');
      $loginUser = $this->session->get('loginUser');
      $users = $this->db_manager->get('User')->getUsers();

      return $this->render(array(
        'errors'  => $errors,
        'loginUser' => $loginUser,
        'users'     => $users,
        '_token'    => $this->generateCsrfToken('account')
      ), 'index');
    }

    return $this->render(array(
      'branchs'     => $branchs,
      'positions'   => $positions,
      'user_name'   => $editedUser['name'],
      'account'     => $editedUser['account'],
      'user_id'     => $editedUser['id'],
      'branch_id'   => $editedUser['branch_id'],
      'position_id' => $editedUser['position_id'],
      '_token'      => $this->generateCsrfToken('account/setting')
    ));
  }

  public function indexAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }
    $this->positionFilter();

    $loginUser = $this->session->get('loginUser');
    $users = $this->db_manager->get('User')->getUsers();


    return $this->render(array(
      'loginUser' => $loginUser,
      'users'     => $users,
      '_token'    => $this->generateCsrfToken('account')
    ));
  }

  public function updateAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }

    if(!$this->request->isPost()){
      $this->forward404();
    }

    $user_id = $this->request->getPost('user_id');

    $token = $this->request->getPost('_token');
    if(!$this->checkCsrfToken('account/setting', $token)){
      return $this->redirect('/account/setting?id='.$user_id);
    }

    $user_name = $this->request->getPost('user_name');
    $account = $this->request->getPost('account');
    $password = $this->request->getPost('password');
    $checkPassword = $this->request->getPost('checkPassword');
    $branch_id = $this->request->getPost('branch_id');
    $position_id = $this->request->getPost('position_id');

    $errors = array();

    if(!strlen($account)){
      $errors[] = "ログインIDを入力してください";
    }else if(!preg_match('/^[[:alnum:]]{6,20}$/', $account)){
      $errors[] = "ログインIDは半角英数字を6~20文字で入力してください";
    }
    if(!$this->db_manager->get('User')->isUniqueUserName($account, $user_id)){
      $errors[] = "ログインIDは既に使用されています";
    }

    if(!empty($password) && (6 > strlen($password) || strlen($password) > 30)){
      $errors[] = "パスワードは6~30文字で入力してください";
    }

    if($password !== $checkPassword){
      $errors[] = "パスワードが一致しません";
    }

    if(!strlen($user_name)){
      $errors[] = "名前を入力してください";
    }else if(mb_strlen($user_name, 'utf8') > 10){
      $errors[] = "名前は10文字で入力してください";
    }

    if(count($errors) === 0){
      $this->db_manager->get('User')->update($account, $user_name, $password, $branch_id, $position_id, $user_id);
      return $this->redirect('/account');
    }

    $branchs = $this->db_manager->get('Branch')->getBranch();
    $positions = $this->db_manager->get('Position')->getPosition();

    return $this->render(array(
      'account'     => $account,
      'user_name'   => $user_name,
      'errors'      => $errors,
      'branchs'     => $branchs,
      'positions'   => $positions,
      'branch_id'   => $branch_id,
      'position_id' => $position_id,
      '_token'      => $this->generateCsrfToken('account/setting')
    ), "setting?id={$user_id}");
  }

  public function freezeAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }

    if(!$this->request->isPost()){
      $this->forward404();
    }

    $user_id = $this->request->getPost('user_id');
    $freezeNow = $this->request->getPost('freeze');
    $this->db_manager->get('User')->freeze($user_id, $freezeNow);
    $loginUser = $this->session->get('loginUser');
    $users = $this->db_manager->get('User')->getUsers();

    return $this->redirect('/account');
  }

  public function deleteAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }

    $user_id = $this->request->getPost('user_id');
    $this->db_manager->get('User')->delete($user_id);
    $loginUser = $this->session->get('loginUser');
    $users = $this->db_manager->get('User')->getUsers();

    return $this->render(array(
      'loginUser' => $loginUser,
      'users'     => $users,
      '_token'    => $this->generateCsrfToken('account')
    ), 'index');
  }
}

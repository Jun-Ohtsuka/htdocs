<?php

class NewThreadController extends Controller{

  protected $auth_actions = array('index', 'post');

  public function indexAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }

    $categoryType = 0;
    $categorys = $this->db_manager->get('Category')->getCategory();

    return $this->render(array(
      'title'         => '',
      'text'          => '',
      'categoryType'  => $categoryType,
      'categorys'     => $categorys,
      'category'      => '',
      '_token'        => $this->generateCsrfToken('newThread/post')
    ));
  }

  public function postAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }

    if(!$this->request->isPost()){
      $this->forward404();
    }

    $submit = $this->request->getPost('submit');
    $categoryType = $this->request->getPost('categoryType');
    $title = $this->request->getPost('title');
    $category = $this->request->getPost('category');

    $text = $this->request->getPost('text');
    $categorys = $this->db_manager->get('Category')->getCategory();

    if($submit === '投稿'){
      $token = $this->request->getPost('_token');
      if(!$this->checkCsrfToken('newThread/post', $token)){
        return $this->redirect('/newThread');
      }

      $errors = array();
      if(!strlen($title)){
        $errors[] = "件名を入力してください";
      }else if(mb_strlen($title, 'utf8') > 50){
        $errors[] = "件名は50文字以内で入力してください";
      }
      if(!strlen($category)){
        $errors[] = "カテゴリーを入力してください";
      }else if(mb_strlen($category, 'utf8') > 10){
        var_dump($category);
        $errors[] = "カテゴリーは10文字以内で入力してください";
      }
      if(!strlen($text)){
        $errors[] = "本文を入力してください";
      }else if(mb_strlen($text, 'utf8') > 1000){
        $errors[] = "本文は1000文字以内で入力してください";
      }

      $loginUser = $this->session->get('loginUser');

      if(count($errors) === 0){
        $this->db_manager->get('Thread')->insert($loginUser['id'], $title, $category, $text);
        return $this->redirect('/');
      }

      return $this->render(array(
        'errors'        => $errors,
        'title'         => $title,
        'categoryType'  => $categoryType,
        'category'      => $category,
        'categorys'     => $categorys,
        'text'          => $text,
        '_token'        => $this->generateCsrfToken('newThread/post')
      ), 'index');
    }else if($submit === '自由入力'){
      $categoryType = 1;

      return $this->render(array(
        'title'         => $title,
        'text'          => $text,
        'categoryType'  => $categoryType,
        'category'      => '',
        '_token'        => $this->generateCsrfToken('newThread/post')
      ), 'index');
    }else if($submit === 'カテゴリー一覧'){
      $categoryType = 0;


      return $this->render(array(
        'title'         => $title,
        'text'          => $text,
        'categoryType'  => $categoryType,
        'categorys'     => $categorys,
        'category'      => $category,
        '_token'        => $this->generateCsrfToken('newThread/post')
      ), 'index');
    }
  }
}

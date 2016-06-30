<?php

class HomeController extends Controller{

  protected $auth_actions = array('index', 'post', 'dlete');

  protected function timeValid($errors = array(), $searchStartYear, $searchStartMonth, $searchStartDay, $searchEndYear, $searchEndMonth, $searchEndDay){

    if(($searchStartYear % 4 == 0) && ($searchStartYear % 100 != 0) || ($searchStartYear % 400 == 0)){
      if($searchStartMonth == "2" && $searchStartDay > 29){
        $errors[] = "START：うるう年なので日付は29日までしか選択できません";
      }
    }else{
      if($searchStartMonth == "2" && $searchStartDay > 28){
        $errors[] = "START：2月を選択した場合、日付は28日までしか選択できません";
      }
    }
    if($searchStartMonth == "4" || $searchStartMonth == "6" || $searchStartMonth == "9" || $searchStartMonth == "11"){
      if($searchStartDay > 30){
        $errors[] = "START：4,6,9,11月を選択した場合、日付は30日までしか選択できません";
      }
    }

    if(($searchEndYear % 4 == 0) && ($searchEndYear % 100 != 0) || ($searchEndYear % 400 == 0)){
      if($searchEndMonth == "2" && $searchEndDay > 29){
        $errors[] = "END：うるう年なので日付は29日までしか選択できません";
      }
    }else{
      if($searchEndMonth == "2" && $searchEndDay > 28){
        $errors[] = "END：2月を選択した場合、日付は28日までしか選択できません";
      }
    }
    if($searchEndMonth == "4" || $searchEndMonth == "6" || $searchEndMonth == "9" || $searchEndMonth == "11"){
      if($searchEndDay > 30){
        $errors[] = "END：4,6,9,11月を選択した場合、日付は30日までしか選択できません";
      }
    }

    $startTime = "{$searchStartYear}-{$searchStartMonth}-{$searchStartDay}";
    $endTime = "{$searchEndYear}-{$searchEndMonth}-{$searchEndDay}";

    if(strtotime($startTime) > strtotime($endTime)){
      $errors[] = "日時検索の開始日時が終了日時より後を指定しています";
    }

    return $errors;
  }

  public function indexAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }

    $startTime = $this->db_manager->get('Thread')->getStartTime();
    $endTime = $this->db_manager->get('Thread')->getEndTime();
    $startTime = date('Y-m-d', strtotime($startTime['insert_date']));
    $startTime = explode("-", $startTime);
    $endTime = date('Y-m-d', strtotime($endTime['insert_date']));
    $endTime = explode("-", $endTime);
    $searchStartYear = $startTime[0];
    $searchStartYear = $startTime[0];
    $searchStartMonth = $startTime[1];
    $searchStartDay = $startTime[2];
    $searchEndYear = $endTime[0];
    $searchEndMonth = $endTime[1];
    $searchEndDay = $endTime[2];
    $category = 'category';

    if(!empty($this->request->getGet('searchCategory'))){
      $category = $this->request->getGet('searchCategory');
    }

    if(!empty($this->request->getGet('startYear'))){
      $searchStartYear = $this->request->getGet('startYear');
    }
    if(!empty($this->request->getGet('startMonth'))){
      $searchStartMonth = $this->request->getGet('startMonth');
    }
    if(!empty($this->request->getGet('startDay'))){
      $searchStartDay = $this->request->getGet('startDay');
    }

    if(!empty($this->request->getGet('endYear'))){
      $searchEndYear = $this->request->getGet('endYear');
    }
    if(!empty($this->request->getGet('endMonth'))){
      $searchEndMonth = $this->request->getGet('endMonth');
    }
    if(!empty($this->request->getGet('endDay'))){
      $searchEndDay = $this->request->getGet('endDay');
    }
    $errors = array();
    $errors = $this->timeValid($errors,$searchStartYear, $searchStartMonth, $searchStartDay, $searchEndYear, $searchEndMonth, $searchEndDay);

    if($this->request->getGet('submit') === '日付リセット'){
      $searchStartYear = $startTime[0];
      $searchStartMonth = $startTime[1];
      $searchStartDay = $startTime[2];
      $searchEndYear = $endTime[0];
      $searchEndMonth = $endTime[1];
      $searchEndDay = $endTime[2];
    }

    $searchStartTime = "{$searchStartYear}-{$searchStartMonth}-{$searchStartDay} 00:00:00";
    $searchEndTime = "{$searchEndYear}-{$searchEndMonth}-{$searchEndDay} 23:59:59";

    $loginUser = $this->session->get('loginUser');
    $threads = $this->db_manager->get('Thread')->fetchAllThread($searchStartTime, $searchEndTime, $category);
    $comments = $this->db_manager->get('Comment')->fetchAllComment();
    $categorys = $this->db_manager->get('Category')->getCategory();

    return $this->render(array(
      'startYear'         => $startTime[0],
      'endYear'           => $endTime[0],
      'searchStartYear'   => $searchStartYear,
      'searchStartMonth'  => $searchStartMonth,
      'searchStartDay'    => $searchStartDay,
      'searchEndYear'     => $searchEndYear,
      'searchEndMonth'    => $searchEndMonth,
      'searchEndDay'      => $searchEndDay,
      'threads'           => $threads,
      'comments'          => $comments,
      'categorys'         => $categorys,
      'category'          => $category,
      'loginUser'         => $loginUser,
      'errors'            => $errors,
      '_token'            => $this->generateCsrfToken('home/post')
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

    $token = $this->request->getPost('_token');
    if(!$this->checkCsrfToken('home/post', $token)){
      return $this->redirect('/');
    }

    $text = $this->request->getPost('text');
    $thread_id = $this->request->getPost('thread_id');

    $errors = array();
    if(!strlen($text)){
      $errors[] = "コメントを入力してください";
    }else if(mb_strlen($text, 'utf8') > 500){
      $errors[] = "コメントは500文字以内で入力してください";
    }

    if(count($errors) === 0){
      $loginUser = $this->session->get('loginUser');

      $this->db_manager->get('Comment')->insert($loginUser['id'], $text, $thread_id);

      return $this->redirect('/');
    }

    $threads = $this->db_manager->get('Thread')->fetchAllThread();
    $comments = $this->db_manager->get('Comment')->fetchAllComment();

    return $this->render(array(
      'errors'  => $errors,
      'text'    => $text,
      'threads' => $threads,
      'comments'=> $comments,
      '_token'  => $this->generateCsrfToken('home/post')
    ), 'index');
  }

  public function threadDeleteAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }

    if(!$this->request->isPost()){
      $this->forward404();
    }

    $token = $this->request->getPost('_token');
    if(!$this->checkCsrfToken('home/post', $token)){
      return $this->redirect('/');
    }

    $thread_id = $this->request->getPost('thread_id');
    $this->db_manager->get('Thread')->delete($thread_id);

    return $this->redirect('/');
  }

  public function commentDeleteAction(){
    if($this->freezeCheck()){
      $this->session->clear();
      $this->session->setAuthenticated(false);

      return $this->redirect('/account/signin');
    }

    if(!$this->request->isPost()){
      $this->forward404();
    }

    $token = $this->request->getPost('_token');
    if(!$this->checkCsrfToken('home/post', $token)){
      return $this->redirect('/');
    }

    $comment_id = $this->request->getPost('comment_id');
    $this->db_manager->get('Comment')->delete($comment_id);

    return $this->redirect('/');
  }
}

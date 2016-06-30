<?php

class BbsApplication extends Application{
  protected $login_action = array('account', 'signin');

  public function getRootDir(){
    return dirname(__FILE__);
  }

  protected function registerRoutes(){
    return array(
      '/' =>
        array('controller' => 'home', 'action' => 'index'),
      '/home/search' =>
        array('controller' => 'home', 'action' => 'index'),
      '/home/:action' =>
        array('controller' => 'home'),
      '/newThread' =>
        array('controller' => 'newThread', 'action' => 'index'),
      '/newThread/post' =>
        array('controller' => 'newThread', 'action' => 'post'),
      '/account' =>
        array('controller' => 'account', 'action' => 'index'),
      '/account/:action' =>
        array('controller' => 'account')
    );
  }

  protected function configure(){
    $this->db_manager->connect('master', array(
      'dsn'       => 'mysql:dbname=php_bbs;host=localhost',
      'user'      => 'root',
      'password'  => 'artonelico'
    ));
  }
}

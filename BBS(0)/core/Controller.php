<?php

abstract class Controller{

  protected function redirect($url){
    header("Location: http://bbs0.local{$url}");
  }
}

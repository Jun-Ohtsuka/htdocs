<?php

namespace Album\Model;

class Album{
  public $id;
  public $name;
  public $score;

  public function exchangeArray($data){
    $this->id     = (isset($data['id'])) ? $data['id'] : null;
    $this->name = (isset($data['name'])) ? $data['name'] : null;
    $this->score  = (isset($data['score'])) ? $data['score'] : null;
  }
}

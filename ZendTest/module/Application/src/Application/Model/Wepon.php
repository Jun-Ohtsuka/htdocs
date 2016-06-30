<?php

namespace Application\Model;

class Wepon{
  public $id;
  public $name;
  public $hp;
  public $atk;
  public $skill_id1;
  public $skill_id2;
  public $skill_level;
  public $type_id;

  public function exchangeArray($data){
    $this->id           = (isset($data['id'])) ? $data['id'] : null;
    $this->name         = (isset($data['name'])) ? $data['name'] : null;
    $this->hp           = (isset($data['hp'])) ? $data['hp'] : null;
    $this->atk          = (isset($data['atk'])) ? $data['atk'] : null;
    $this->skill_id1    = (isset($data['skill_id1'])) ? $data['skill_id1'] : null;
    $this->skill_id2    = (isset($data['skill_id2'])) ? $data['skill_id2'] : null;
    $this->skill_level  = (isset($data['skill_level'])) ? $data['skill_level'] : null;
    $this->type_id      = (isset($data['type_id'])) ? $data['type_id'] : null;
  }
}

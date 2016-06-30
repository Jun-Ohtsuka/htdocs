<?php

$controller = $_POST['controller']."Action";

$controller();

function insertAction(){
  $name = $_POST['name'];
  $hp = $_POST['hp'];
  $atk = $_POST['atk'];
  $type_id = $_POST['type_id'];
  $skill_id1 = $_POST['skill_id1'];
  $skill_id2 = $_POST['skill_id2'];
  $skillLevel = $_POST['skillLevel'];

  $add_wepon = array(
    'name'        => $name,
    'hp'          => $hp,
    'atk'         => $atk,
    'type_id'     => $type_id,
    'skill_id1'   => $skill_id1,
    'skill_id2'   => $skill_id2,
    'skillLevel'  => $skillLevel
  );

  require '../repository/WeponRepository.php';
  $PDO = new WeponRepository;
  $PDO->insertWepon($add_wepon);

  header('Location: http://study.localhost/granblueWepon');
}

function updateAction(){
  $id = $_POST['id'];
  $name = $_POST['name'];
  $hp = $_POST['hp'];
  $atk = $_POST['atk'];
  $type_id = $_POST['type_id'];
  $skill_id1 = $_POST['skill_id1'];
  $skill_id2 = $_POST['skill_id2'];
  $skillLevel = $_POST['skillLevel'];

  $add_wepon = array(
    'name'        => $name,
    'hp'          => $hp,
    'atk'         => $atk,
    'type_id'     => $type_id,
    'skill_id1'   => $skill_id1,
    'skill_id2'   => $skill_id2,
    'skillLevel'  => $skillLevel
  );

  require '../repository/WeponRepository.php';
  $PDO = new WeponRepository;
  $PDO->updateWepon($add_wepon, $id);

  header('Location: http://study.localhost/granblueWepon');
}

function deleteAction(){
  $id = $_POST['id'];

  require '../repository/WeponRepository.php';
  $PDO = new WeponRepository;
  $PDO->deleteWepon($id);

  header('Location: http://study.localhost/granblueWepon');
}

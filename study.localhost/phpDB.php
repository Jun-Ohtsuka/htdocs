<?php

require_once 'idiorm.php';

ORM::configure('mysql:dbhost=localhost;dbname=php_db');
ORM::configure('username', 'root');
ORM::configure('password', 'artonelico');

// $name = 'fkoji';
// $users = ORM::for_table('users')->where('name', $name)->find_array();
//
// foreach ($users as $value) {
// 	//echo "({$value['id']}) : {$value['name']}<br />";
// 	echo "({$value['id']}){$value['name']} : {$value['score']}";
// }

$id = '10';
$name = "zyta";
$score = "99";

//updateUser($id, $name, $score);
deleteUser($id);


function updateUser($id, $name, $score){
	$add_user = array(
		'name' => $name,
		'score' => $score
	);
	$user = ORM::for_table('users')->find_one($id);
	$user->set($add_user);
	$user->save();
}

function deleteUser($id){
	$user = ORM::for_table('users')->find_one($id);
	$user->delete();
}

function insertUser($name, $score){
	$add_user = array(
		'name' => $name,
		'score' => $score
	);
	$user = ORM::for_table('users')->create();
	$user->set($add_user);
	$user->save();
}

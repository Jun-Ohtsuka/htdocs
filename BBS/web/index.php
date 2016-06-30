<?php

require '../bootstrap.php';
require '../BbsApplication.php';
require('../models/BranchRepository.php');

$app = new BbsApplication(false);
$app->run();
$getBranch = new BranchRepository;
$branchs = new getBranch();
echo escape($branchs);

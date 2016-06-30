<?php

$this->setLayoutVar('title', $status['user_name']);

echo $this->render('status/status', array('status' => $status));

<?php
require_once 'idiorm.php';

ORM::configure('mysql:dbhost=localhost;dbname=granblue');
ORM::configure('username', 'root');
ORM::configure('password', 'artonelico');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Pser\Http\Messag\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App();

$app->get('/hello/{name}', function($request, $response, $args){
  $response->getBody()->write("Hello, {$args['name']}");

  return $response;
});
// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();

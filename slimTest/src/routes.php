<?php
// Routes

$app->get('/hello/{name}', function ($request, $response, $args) {
  return $this->view->render($response, 'profile.html', []);
});

// $app->get('/hello/{name}', function ($request, $response, $args) {                                                                                   
//     $html = $this->view->fetch('profile.html', [
//         'name' => $args['name']
//     ]);
//     // $htmlを使った何らかの処理
//
//     return $response->withJson(['status'=>'success']);
// });

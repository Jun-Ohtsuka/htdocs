<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        // View settings
       'view' => [
           'template_path' => __DIR__ . '/../tempaltes/',
           'twig' => [
               'cache' => __DIR__ . '',
               'debug' => true,
               'auto_reload' => true,
             ],
           ],
    ],
];

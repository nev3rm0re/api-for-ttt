<?php
require_once(__DIR__ . '/../vendor/autoload.php');

$app = new \Slim\App(
    [
        'settings' => [
            'displayErrorDetails' => true
        ]
    ]
);
$container = $app->getContainer();
$container['view'] = function($container) {
    $view = new \Slim\Views\Twig('../templates', [
        'cache' => false
    ]);

    $base_path = rtrim(
        str_ireplace(
            'index.php',
            '',
            $container['request']->getUri()->getBasePath()),
        '/'
    );
    $view->addExtension(new \Slim\Views\TwigExtension($container['router'], $base_path));
    return $view;
};

return $app;
// node.js much? :)
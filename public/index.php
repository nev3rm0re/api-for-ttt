<?php
require_once __DIR__ . '/../vendor/autoload.php';

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

$app->post(
    '/jsonrpc/v1/',
    function ($req, $res) {
        $game = new \Egoh\TicTacToe();
        $jsonrpc = json_decode($req->getBody(), true);
        // let's skip validation for now
        $board_state = $jsonrpc["params"]["boardState"];
        $player = $jsonrpc["params"]["player"];

        try {
            $move = $game->makeMove($board_state, $player);
            if (empty($move)) {
                $jsonrpc_error = new \Egoh\JsonRpcError($jsonrpc['id']);
                return $res->withJson($jsonrpc_error->toJson());
            }

            $jsonrpc_result = [
                'jsonrpc' => "2.0",
                'result' => $move,
                'id' => $jsonrpc["id"]
            ];
            return $res->withJson($jsonrpc_result);
        } catch (\Exception $e) {
            $jsonrpc_error = new \Egoh\JsonRpcError($jsonrpc['id'], ['code' => 400, 'message' => 'Bad request']);
            return $res->withJson($jsonrpc_error->toJson());
        }
    }
);

$app->get('/client', function($request, $response, $args) {
    return $this->view->render($response, 'index.twig');
});

$app->run();

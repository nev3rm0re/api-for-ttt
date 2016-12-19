<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App(
    [
        'settings' => [
            'displayErrorDetails' => true
        ]
    ]
);

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
                $jsonrpc_error = [
                    'jsonrpc' => "2.0",
                    'error' => [],
                    'id' => $jsonrpc["id"]
                ];

                return $res->withJson($jsonrpc_error);
            }

            $jsonrpc_result = [
                'jsonrpc' => "2.0",
                'result' => $move,
                'id' => $jsonrpc["id"]
            ];
            return $res->withJson($jsonrpc_result);
        } catch (\Exception $e) {
            $jsonrpc_error = [
                'jsonrpc' => '2.0',
                'result' => null,
                'error' => [
                    'code' => 400,
                    'message' => "Bad request"
                ]
            ];
            return $res->withJson($jsonrpc_error);
        }
    }
);

$app->run();
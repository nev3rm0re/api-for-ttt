<?php
namespace Egoh\Controllers;

class JsonRpc
{
    protected $container;
    public function __construct($container) {
        $this->container = $container;
    }

    public function attach($mount_point, $app) {
        // For some reason Slim is acting up here - gives 404. Double slashes?
        // so just removing trailing slash in case it's there
        $mount_point = rtrim($mount_point, '/');

        $app->group($mount_point, function() {
            $this->post('/', function ($req, $res) {
                $game = new \Egoh\TicTacToe();
                $jsonrpc = json_decode($req->getBody(), true);
                // let's skip validation for now
                $board_state = $jsonrpc["params"]["boardState"];
                $player = $jsonrpc["params"]["player"];

                try {
                    $move = $game->makeMove($board_state, $player);

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
            });
        });
    }
}
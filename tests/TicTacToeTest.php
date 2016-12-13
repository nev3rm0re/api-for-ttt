<?php

class TicTacToeTest extends \PHPUnit_Framework_TestCase
{
    public function movesProvider()
    {
        $empty_board = array_fill(0, 3, array_fill(0, 3, ''));
        $full_board = array_fill(0, 3, array_fill(0, 3, 'X'));
        $full_board[2][2] = '';

        return [
            "empty board" => [
                'board' => $empty_board, 
                'player' => 'X', 
                "expected_move" => [0, 0, 'X']
            ],
            "only move" => [
                'board' => $full_board,
                'player' => 'X',
                'expected_move' => [2, 2, 'X']
            ]
        ];
    }

    /**
    * @dataProvider movesProvider
    */
    public function testMakeMove($board, $player, $expected_move)
    {
        $testee = new \Egoh\TicTacToe();
        $move = $testee->makeMove($board, $player);

        $this->assertEquals($expected_move, $move);
    }

    public function testMakeMoveWithInvalidBoard()
    {
        $invalid_board = '';
        $current_player = 'X';

        $testee = new \Egoh\TicTacToe();
        $this->expectException(\Exception::class);
        $testee->makeMove($invalid_board, $current_player);
    }
}
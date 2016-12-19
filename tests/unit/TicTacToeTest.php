<?php

class TicTacToeTest extends \PHPUnit_Framework_TestCase
{
    public function movesProvider()
    {
        $empty_row = array_fill(0, 3, '');
        $full_row = array_fill(0, 3, 'X');

        $empty_board = array_fill(0, 3, $empty_row);

        $full_board = array_fill(0, 3, $full_row);
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
            ],
            "half full board" => [
                'board' => [$full_row, $empty_row, $empty_row],
                'player' => 'O',
                'expected_move' => [1, 0, 'O']
            ],
            "full board" => [
                'board' => [$full_row, $full_row, $full_row],
                'player' => 'O',
                'expected_move' => []
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

<?php

class TicTacToeTest extends \PHPUnit_Framework_TestCase
{
    public function movesProvider()
    {
        $empty_row = array_fill(0, 3, '');
        $full_row = array_fill(0, 3, 'X');
        $odd_full_row = ['X', 'O', 'X'];
        $even_full_row = ['O', 'X', 'O'];

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
                'board' => [$even_full_row, $odd_full_row, ['X', 'O', '']],
                'player' => 'X',
                'expected_move' => [2, 2, 'X']
            ],
            "half full board" => [
                'board' => [$odd_full_row, $empty_row, $empty_row],
                'player' => 'O',
                'expected_move' => [1, 0, 'O']
            ],
            "full board" => [
                'board' => [$odd_full_row, $even_full_row, $odd_full_row],
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

    public function invalidBoardsProvider() {
        $empty_row = array_fill(0, 3, '');
        $full_row = array_fill(0, 3, 'X');

        return [
            "bad format - empty string" => [
                ""
            ],
            "bad format - wrong dimensions" => [
                ["", "", "", ""], ["", "", ""], [""]
            ]
        ];
    }

    /**
    * Attempt to make a move on improperly formatted board
    * should throw Exception
    *
    * @dataProvider invalidBoardsProvider
    */
    public function testMakeMoveWithImproperlyFormattedBoard($invalid_board)
    {
        $current_player = 'X';

        $testee = new \Egoh\TicTacToe();
        $this->expectException(\Exception::class);
        $testee->makeMove($invalid_board, $current_player);
    }
}

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

    public function winningBoardProvider()
    {
        return [
            "Pick winning one out of only two available" => [
                'board' => [
                    ['X', 'O', 'X'],
                    ['O', 'X', 'O'],
                    ['O', '',  '']
                ],
                'player' => 'X',
                'expectedMoves' => [[2, 2, 'X']]
            ],
            "Pick winning one out of three available" => [
                'board' => [
                    ['X', 'O', ''],
                    ['X',  '', 'X'],
                    [ '',  'O', 'O']
                ],
                'player' => 'X',
                'expectedMoves' => [
                    [1, 1, 'X'],
                    [2, 0, 'X'],
                ]
            ],
            "Prevent opposing player from winning" => [
                'board' => [
                    ['X', 'O', ''],
                    ['X',  '', ''],
                    [ '',  '', '']
                ],
                'player' => 'O',
                'expectedMoves' => [
                    [2, 0, 'O']
                ]
            ]
        ];
    }
    /**
    * Bot should pick winning move
    * @dataProvider winningBoardProvider
    */
    public function testBotPicksWinningMove($winning_board, $player, $expected)
    {
        $testee = new \Egoh\TicTacToe(new \Egoh\SmartBrain());
        $move = $testee->makeMove($winning_board, $player);

        $this->assertContains(
            $move,
            $expected,
            "Calculated move is one of expected ones."
        );
    }
}

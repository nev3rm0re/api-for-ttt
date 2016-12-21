<?php

class BoardTest extends \PHPUnit_Framework_TestCase
{
    public function invalidBoardProvider() {
        $empty_row = array_fill(0, 3, '');
        $full_row = array_fill(0, 3, 'X');

        return [
            "no player 2" => [
                [['X', 'X', ''], $empty_row, $empty_row]
            ],
            "too little of player 1" => [
                [['O', 'O', 'O'], ['O', 'X', 'X'], $empty_row]
            ],
            /* horizontals */
            "Finished board #1" => [
                [['X', 'X', 'X'], ['O', 'O', ''], $empty_row]
            ],
            "Finished board #2" => [
                [['O', 'O', ''], $full_row, $empty_row]
            ],
            "Finished board #3" => [
                [$empty_row, ['O', 'O', ''], $full_row]
            ],
            /* verticals */
            "Finished board #4" => [
                [['O', 'X', ''], ['O', 'X', ''], ['O', 'X', '']]
            ],
            "Finished board #5" => [
                [
                    ['O', '', 'X'],
                    ['O', '', 'X'],
                    ['', '', 'X']
                ]
            ],
            "Finished board #6" => [
                [
                    ['O', 'O', 'X'],
                    ['O', 'X', 'O'],
                    ['O', 'X', '']
                ]
            ],
            /* diagonals */
            "Finished board #7" => [
                [
                    ['O', 'X', 'X'],
                    ['X', 'O', 'O'],
                    ['X', '',  'O']
                ]
            ],
            "Finished board #8" => [
                [
                    ['O', 'X', 'X'],
                    ['O', 'X', 'O'],
                    ['X',  '',  '']
                ]
            ]
        ];
    }
    /**
    * @dataProvider invalidBoardProvider
    */
    public function testIsValidByRulesThrowsException($invalid_board)
    {
        $board = new \Egoh\Board();

        // $this->expectException(\LogicException::class);
        $board->fromArray($invalid_board);

        $this->assertFalse($board->isValidByRules());
        echo $board->getLastError();
    }
}
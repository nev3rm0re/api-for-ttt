<?php
namespace Egoh;

class Board
{
    protected $last_error;
    public function getLastError() {
        return $this->last_error;
    }

    protected $size;
    public function __construct($size = 3)
    {
        $this->size = $size;
    }

    protected function isValid($board_state)
    {
        // check dimensions first: must be 3x3
        if (!is_array($board_state)
            || count(
                array_filter(
                    $board_state,
                    function ($el) {
                        return is_array($el) && count($el) == 3;
                    }
                )
            ) != 3
        ) {
            $this->last_error = 'Dimensions are wrong: ' . json_encode($board_state);
            return false;
        }

        return true;
    }

    public function validateBoard()
    {
        if (!$this->isValidByRules()) {
            throw new \LogicException(
                "Board is invalid by rules: " . $this->getLastError()
            );
        }
    }

    public function isValidByRules()
    {
        $flat_board = $this->flat_board;

        // Rule 1: Both players must have roughly same number of tokens on the board
        $player_1 = count(array_filter($flat_board, function($el) {
            return ($el == 'X');
        }));

        $player_2 = count(array_filter($flat_board, function($el) {
            return ($el == 'O');
        }));

        if (abs($player_1 - $player_2) > 1) {
            $this->last_error = 'Wrong counts: ' . $player_1 . '/' . $player_2;
            return false;
        }

        if ($this->isWin($flat_board)) {
            // $this->last_error = 'Win condition';
            return false;
        }
        return true;
    }

    public function isWinFor($player) {
        return $this->isWin($this->flat_board, $player);
    }

    public function isWin($flat_board, $player = null) {
        if ($player === null) {
            return
                $this->isWin($flat_board, 'X')
                || $this->isWin($flat_board, 'O');
        }

        // if ($this->isBoardFinished($flat_board)) {
        $output = array_map(function($el) use ($player) {
            return $el == $player ? '1' : '0';
        }, $flat_board);
        $state = bindec(implode('', $output));

        $patterns = [
            /* horizontals */
            7 * pow(2, 6),
            7 * pow(2, 3),
            7 * 1,
            /* verticals */
            bindec('100100100'),
            bindec('010010010'),
            bindec('001001001'),
            bindec(
                '100'.
                '010'.
                '001'
                ),
            bindec(
                '001'.
                '010'.
                '100'
            )
        ];

        foreach ($patterns as $pattern) {
            if (($state & $pattern) == $pattern) {
                $this->last_error = 'WIN match: ' . $pattern . ' - ' . decbin($pattern) . "; state: $state - " . decbin($state);
                return true;
            }
        }
        return false;
    }

    protected $flat_board;
    public function fromArray($board_state)
    {
        if (!$this->isValid($board_state)) {
            throw new \Exception("Invalid board: " . $this->getLastError());
        }

        $flat_board = [];

        for ($i = 0; $i <= 2; $i++) {
            for ($n = 0; $n <= 2; $n++) {
                $value = $board_state[$i][$n];
                if ($value === '') {
                    $flat_board[] = '_';
                } else {
                    $flat_board[] = $value;
                }
            }
        }

        $this->flat_board = $flat_board;
    }

    public function toArray()
    {
        // normalize flat board
        $normalized_flat_board = array_map(
            function($el) {
                return ($el == '_') ? '' : $el;
            },
            $this->flat_board
        );

        return [
            // don't you hate it when PHP syntax is diffent from normal one
            // third param here is $length, not the end index like in JS
            array_slice($normalized_flat_board, 0, 3),
            array_slice($normalized_flat_board, 3, 3),
            array_slice($normalized_flat_board, 6, 3)
        ];
    }

    public function findAvailableMoves()
    {
        $moves = [];

        // if (!$this->isValidByRules()) {
        //     // If board is not valid by rules - no moves are available
        //     return $moves;
        // }

        $callback = function ($value) {
            return ($value == '_');
        };

        $keys = array_filter($this->flat_board, $callback);
        foreach (array_keys($keys) as $index) {
            $moves[] = [(int) floor($index / $this->size), $index % $this->size];
        }
        return $moves;
    }
}

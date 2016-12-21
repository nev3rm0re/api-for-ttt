<?php
namespace Egoh;

class Board
{
    protected $last_error;

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
            return false;
        }

        return true;
    }

    public function isValidByRules($flat_board)
    {
        // Rule 1: Both players must have roughly same number of tokens on the board
        $player_1 = count(array_filter($flat_board, function($el) {
            return ($el == 'X');
        }));

        $player_2 = count(array_filter($flat_board, function($el) {
            return ($el == 'O');
        }));

        if (abs($player_1 - $player_2) > 1) {
            return false;
        }

        // if ($this->isBoardFinished($flat_board)) {
            $output = array_map(function($el) {
                return $el == 'X' ? '1' : '0';
            }, $flat_board);
            $state = bindec(implode('', $output));

            $patterns = [
                7 * pow(2, 6)
            ];

            foreach ($patterns as $pattern) {
                if (($state & $pattern) == $pattern) {
                    $this->last_error = 'WIN match: ' . $pattern . ' - ' . decbin($pattern) . "; state: $state - " . decbin($state);
                    return false;
                }
            }
        // }
        return true;
    }

    protected $flat_board;
    public function fromArray($board_state)
    {
        if (!$this->isValid($board_state)) {
            throw new \Exception("Invalid board");
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

        if (!$this->isValidByRules($flat_board)) {
            throw new \LogicException('Board violates rules: ' . $this->last_error);
        }
    }

    public function findAvailableMoves()
    {
        $callback = function ($value) {
            return ($value == '_');
        };

        $keys = array_filter($this->flat_board, $callback);
        $moves = [];
        foreach (array_keys($keys) as $index) {
            $moves[] = [floor($index / $this->size), $index % $this->size];
        }
        return $moves;
    }
}

<?php
namespace Egoh;

class Board
{
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
        $player_1 = count(array_filter($flat_board, function($el) {
            return ($el == 'X');
        }));

        $player_2 = count(array_filter($flat_board, function($el) {
            return ($el == 'O');
        }));
        echo "Count of #1", $player_1;
        echo "Count of #2", $player_2;
        return (abs($player_1 - $player_2) <= 1);
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
            throw new \LogicException('Board violates rules');
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

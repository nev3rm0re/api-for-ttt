<?php
namespace Egoh;

class Board
{
    private $size;
    public function __construct($size = 3)
    {
        $this->size = $size;
    }

    private $flat_board;
    public function fromArray($board_state)
    {
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

    public function findAvailableMoves()
    {
        $callback = function($value, $key) {
            return ($value == '_');
        };
        $keys = array_filter($this->flat_board, $callback, ARRAY_FILTER_USE_BOTH);
        $moves = [];
        foreach (array_keys($keys) as $index) {
            $moves[] = [floor($index / $this->size), $index % $this->size];
        }
        return $moves;
    }
}
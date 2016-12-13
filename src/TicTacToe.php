<?php
namespace Egoh;

class TicTacToe implements MoveInterface
{
    public function isBoardValid($board): bool
    {
        // check dimensions first: must be 3x3
        if (
            !is_array($board) || 
            count($filtered = array_filter(
                $board, 
                function($el) { 
                    return is_array($el) && count($el) == 3;
                })
            ) != 3
        ) {
            return false;
        }
        
        return true;    
    }

    public function makeMove($boardState, $playerUnit = 'X'): array 
    {
        if (!$this->isBoardValid($boardState)) {
            throw new \Exception("Invalid board");
        }

        $moves = $this->findAvailableMoves($boardState);
        // pick first one
        return array_merge($moves[0], [$playerUnit]);
    }

    private function findAvailableMoves($boardState)
    {
        $flat_board = [];

        for ($i = 0; $i <= 2; $i++) {
            for ($n = 0; $n <= 2; $n++) {
                $value = $boardState[$i][$n];
                if ($value === '') {
                    $flat_board[] = '_';
                } else {
                    $flat_board[] = $value;
                }
            }
        }
        $callback = function($value, $key) {
            return ($value == '_');
        };
        $keys = array_filter($flat_board, $callback, ARRAY_FILTER_USE_BOTH);
        $moves = [];
        foreach (array_keys($keys) as $index) {
            $moves[] = [floor($index / 3), $index % 3];
        }
        return $moves;
    }
}
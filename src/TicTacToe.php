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
        return $moves[0];
    }

    private function findAvailableMoves($boardState)
    {
        // flatten board
        array_reduce($)
    }
}
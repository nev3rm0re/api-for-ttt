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

        $board = new Board(3);
        $board->fromArray($boardState);

        $moves = $board->findAvailableMoves();
        // pick first one
        return array_merge($moves[0], [$playerUnit]);
    }
}
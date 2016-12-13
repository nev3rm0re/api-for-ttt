<?php
namespace Egoh;

class TicTacToe implements MoveInterface
{
    public function makeMove($boardState, $playerUnit = 'X'): array 
    {
        $board = new Board(3);
        $board->fromArray($boardState);

        $moves = $board->findAvailableMoves();
        // pick first one
        return array_merge($moves[0], [$playerUnit]);
    }
}
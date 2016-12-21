<?php
namespace Egoh;

class TicTacToe implements MoveInterface
{
    public function makeMove($boardState, $playerUnit = 'X')
    {
        $board = new Board(3);
        $board->fromArray($boardState);

        $moves = $board->findAvailableMoves();

        if (empty($moves)) {
            return [];
        }

        // pick first one
        return array_merge($moves[0], [$playerUnit]);
    }
}

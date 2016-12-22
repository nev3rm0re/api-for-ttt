<?php
namespace Egoh;

class TicTacToe implements MoveInterface
{
    public function makeMove($boardState, $playerUnit = 'X')
    {
        $board = new Board(3);
        $board->fromArray($boardState);

        $moves = $board->findAvailableMoves();

        if (empty($moves) || !$board->isValidByRules()) {
            return [];
        }

        return $this->pickMove($moves, $playerUnit);
    }

    /**
    * The brains behind the bot
    *
    * @param array  $moves  List of available moves to pick from
    * @param string $playerUnit  Player to pick move for
    */
    protected function pickMove($moves, $playerUnit)
    {
        // no point in checking if $moves not empty - we are protected
        // and there's a check right above for that
        return array_merge($moves[0], [$playerUnit]);
    }
}

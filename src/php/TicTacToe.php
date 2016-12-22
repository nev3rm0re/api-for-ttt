<?php
namespace Egoh;

class TicTacToe implements MoveInterface
{
    protected $board;

    public function makeMove($boardState, $playerUnit = 'X')
    {
        // This is a switch to be used during development
        // this will use `pickMoveV2` logic by default
        $use_latest = true;

        $board = new Board(3);
        $board->fromArray($boardState);

        $moves = $board->findAvailableMoves();

        if (empty($moves) || !$board->isValidByRules()) {
            return [];
        }

        $this->board = $board;

        if ($use_latest) {
            return $this->pickMoveV2($moves, $playerUnit);
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

    /**
    * This is version 2 of the brain
    * So far it's just a copy of original logic
    */
    public function pickMoveV2($moves, $playerUnit)
    {
        foreach ($moves as $move) {
            $board_state = $this->board->toArray();
            $board_state[$move[0]][$move[1]] = $playerUnit;

            $board = new Board(3);
            $board->fromArray($board_state);
            if ($board->isWinFor($playerUnit)) {
                return array_merge($move, [$playerUnit]);
            }
        }
        // if all else fails - resort to our dumb counterpart
        return $this->pickMove($moves, $playerUnit);
    }
}

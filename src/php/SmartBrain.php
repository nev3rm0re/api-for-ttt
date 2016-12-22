<?php
namespace Egoh;

class SmartBrain
{
    protected $board;
    public function setBoard($board)
    {
        $this->board = $board;
    }

    public function pickMove($moves, $playerUnit)
    {
        $opponent = ($playerUnit == 'X' ? 'O': 'X');

        $good_moves = [];

        foreach ($moves as $move) {
            /*
            * Yeah, I know, this does look like a nice place for recursion
            * But, wierdly enough, that's enough logic not to allow human to
            * win, so let's leave it like that for now
            */
            $board_state = $this->board->toArray();
            $board_state[$move[0]][$move[1]] = $playerUnit;

            $board = new Board(3);
            $board->fromArray($board_state);

            if ($board->isWinFor($playerUnit)) {
                return array_merge($move, [$playerUnit]);
            }

            $next_moves = $board->findAvailableMoves();
            $next_state = $board->toArray();

            $bad_moves = array_filter(
                $next_moves,
                function($next_move) use ($next_state, $opponent){
                    $next_state[$next_move[0]][$next_move[1]] = $opponent;
                    $next_board = new Board(3);
                    $next_board->fromArray($next_state);

                    return $next_board->isWinFor($opponent);
                }
            );
            if (count($bad_moves) == 0) {
                // opponent doesn't win next turn - that's a good move
                $good_moves[] = $move;
            }
        }

        if (count($good_moves) > 0) {
            return array_merge($good_moves[0], [$playerUnit]);
        } else {
            // Nothing is particulary good, so let's pick the first one
            return array_merge($moves[0], [$playerUnit]);
        }
    }
}
<?php
namespace Egoh;

class DumbBrain
{
    public function setBoard($board)
    {
        $this->board = $board;
    }

    public function pickMove($moves, $playerUnit)
    {
        return array_merge($moves[0], [$playerUnit]);
    }
}
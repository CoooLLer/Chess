<?php

namespace App\Model;

use App\Interfaces\ChessPieceInterface;
use App\Traits\ChessPieceTrait;

class Queen implements ChessPieceInterface
{
    use ChessPieceTrait;

    private array $symbol = [
        'b' =>'q',
        'w' => 'Q'
    ];

    private int $shift = 4;

    const OFFSETS = [-17, -16, -15,   1,  17,  16,  15,  -1];
}
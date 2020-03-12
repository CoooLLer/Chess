<?php

namespace App\Model;

use App\Interfaces\ChessPieceInterface;
use App\Traits\ChessPieceTrait;

class Rook implements ChessPieceInterface
{
    use ChessPieceTrait;

    private array $symbol = [
        'b' =>'r',
        'w' => 'R'
    ];

    private int $shift = 3;

    const OFFSETS = [-16,   1,  16,  -1];
}
<?php

namespace App\Model;

use App\Interfaces\ChessPieceInterface;
use App\Traits\ChessPieceTrait;

class King implements ChessPieceInterface
{
    use ChessPieceTrait;

    private array $symbol = [
        'b' => 'k',
        'w' => 'K'
    ];

    private int $shift = 5;

    const OFFSETS = [-17, -16, -15, 1, 17, 16, 15, -1];

}
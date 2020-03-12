<?php

namespace App\Model;

use App\Interfaces\ChessPieceInterface;
use App\Traits\ChessPieceTrait;

class Bishop implements ChessPieceInterface
{
    use ChessPieceTrait;

    private array $symbol = [
        'b' =>'b',
        'w' => 'B'
    ];

    private int $shift = 2;

    const OFFSETS = [-17, -15,  17,  15];

}
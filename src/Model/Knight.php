<?php

namespace App\Model;

use App\Interfaces\ChessPieceInterface;
use App\Traits\ChessPieceTrait;

class Knight implements ChessPieceInterface
{
    use ChessPieceTrait;

    private array $symbol = [
        'b' =>'n',
        'w' => 'N'
    ];

    private int $shift = 1;

    const OFFSETS = [-18, -33, -31, -14,  18,  33,  31,  14];
}
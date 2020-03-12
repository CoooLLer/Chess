<?php
namespace App\Model;

use App\Interfaces\ChessPieceInterface;
use App\Traits\ChessPieceTrait;

class Pawn implements ChessPieceInterface
{
    use ChessPieceTrait;
    private array $symbol = [
        'b' =>'p',
        'w' => 'P'
    ];

    private int $shift = 0;

    const OFFSETS = [
        'b' => [16,  32,  17,  15],
        'w' => [-16, -32, -17, -15],
    ];

    public function getOffsets(): array
    {
        return self::OFFSETS[$this->getColor()];
    }
}
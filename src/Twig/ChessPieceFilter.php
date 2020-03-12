<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ChessPieceFilter extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('chessSymbolToFontawesomeIcon', [$this, 'convertChessSymbolToFontawesomeIcon'], [
                'is_safe' => ['html']
            ]),
        ];
    }

    public function convertChessSymbolToFontawesomeIcon($symbol)
    {
        $icon = '';

        switch (strtolower($symbol)) {
            case 'p': //Pawn
                $icon = '<i class="fas fa-chess-pawn"></i>';
                if ($symbol === 'P') {
                    $icon = '<span class="chess-piece-white">' . $icon . '</span>';
                }
                break;
            case 'n': //Knight
                $icon = '<i class="fas fa-chess-knight"></i>';
                if ($symbol === 'N') {
                    $icon = '<span class="chess-piece-white">' . $icon . '</span>';
                }
                break;
            case 'b': //Bishop
                $icon = '<i class="fas fa-chess-bishop"></i>';
                if ($symbol === 'B') {
                    $icon = '<span class="chess-piece-white">' . $icon . '</span>';
                }
                break;
            case 'r': //Rook
                $icon = '<i class="fas fa-chess-rook"></i>';
                if ($symbol === 'R') {
                    $icon = '<span class="chess-piece-white">' . $icon . '</span>';
                }
                break;
            case 'q': //Queen
                $icon = '<i class="fas fa-chess-queen"></i>';
                if ($symbol === 'Q') {
                    $icon = '<span class="chess-piece-white">' . $icon . '</span>';
                }
                break;
            case 'k': //King
                $icon = '<i class="fas fa-chess-king"></i>';
                if ($symbol === 'K') {
                    $icon = '<span class="chess-piece-white">' . $icon . '</span>';
                }
                break;
        }

        return $icon;
    }
}
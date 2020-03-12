<?php


namespace App\Service;


use App\Interfaces\ChessPieceInterface;
use App\Model\Bishop;
use App\Model\ChessGame;
use App\Model\King;
use App\Model\Knight;
use App\Model\Pawn;
use App\Model\Queen;
use App\Model\Rook;
use InvalidArgumentException;

class ChessPieceGenerator
{
    /**
     * Generate chess piece object by type
     * @param string $type
     * @return ChessPieceInterface
     */
    public static function getChessPiece($type): ChessPieceInterface
    {
        if (strpos(ChessGame::ALLOWED_SYMBOLS, $type) === false) {
            throw new InvalidArgumentException('Wrong piece type passed: ' . $type);
        }

        $object = null;
        switch (strtolower($type)) {
            case 'p': //Pawn
                $object = new Pawn();
                $object->setColor($type === 'P' ? 'w' : 'b');
                break;
            case 'n': //Knight
                $object = new Knight();
                $object->setColor($type === 'N' ? 'w' : 'b');
                break;
            case 'b': //Bishop
                $object = new Bishop();
                $object->setColor($type === 'B' ? 'w' : 'b');
                break;
            case 'r': //Rook
                $object = new Rook();
                $object->setColor($type === 'R' ? 'w' : 'b');
                break;
            case 'q': //Queen
                $object = new Queen();
                $object->setColor($type === 'Q' ? 'w' : 'b');
                break;
            case 'k': //King
                $object = new King();
                $object->setColor($type === 'K' ? 'w' : 'b');
                break;
        }

        return $object;

    }
}
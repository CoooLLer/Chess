<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FenString extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $messages = [
        0 => 'No errors.',
        1 => 'FEN string must contain six space-delimited fields.',
        2 => '6th field (move number) must be a positive integer.',
        3 => '5th field (half move counter) must be a non-negative integer.',
        4 => '4th field (en-passant square) is invalid.',
        5 => '3rd field (castling availability) is invalid.',
        6 => '2nd field (side to move) is invalid.',
        7 => '1st field (piece positions) does not contain 8 \'/\'-delimited rows.',
        8 => '1st field (piece positions) is invalid [consecutive numbers].',
        9 => '1st field (piece positions) is invalid [invalid piece].',
        10 => '1st field (piece positions) is invalid [row too large].',
        11 => 'Illegal en-passant square',
    ];
}

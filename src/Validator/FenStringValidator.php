<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FenStringValidator extends ConstraintValidator
{
    const ALLOWED_PIECES_SYMBOLS = 'pnbrqkPNBRQK';

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\FenString */


        if (null === $value || '' === $value) {
            return;
        }

        $tokens = explode(' ', $value);
        $errorsNumbers = [];

        // 1st criterion: 6 space-separated fields
        if (count($tokens) !== 6) {
            $this->addViolation($constraint, 1);
            return;
        }

        // 2nd criterion: move number field is a integer value > 0
        if (!ctype_digit($tokens[5]) || intval($tokens[5], 10) <= 0) {
            $this->addViolation($constraint, 2);
            return;
        }

        // 3rd criterion: half move counter is an integer >= 0
        if (!ctype_digit($tokens[4]) || intval($tokens[4], 10) < 0) {
            $this->addViolation($constraint, 3);
            return;
        }

        // 4th criterion: 4th field is a valid e.p.-string
        if (!(preg_match('/^(-|[a-h]{1}[3|6]{1})$/', $tokens[3]) === 1)) {
            $this->addViolation($constraint, 4);
            return;
        }

        // 5th criterion: 3th field is a valid castle-string
        if (!(preg_match('/(^-$)|(^[K|Q|k|q]{1,}$)/', $tokens[2]) === 1)) {
            $this->addViolation($constraint, 5);
            return;
        }

        // 6th criterion: 2nd field is "w" (white) or "b" (black)
        if (!(preg_match('/^(w|b)$/', $tokens[1]) === 1)) {
            $this->addViolation($constraint, 6);
            return;
        }

        // 7th criterion: 1st field contains 8 rows
        $rows = explode('/', $tokens[0]);
        if (count($rows) !== 8) {
            $this->addViolation($constraint, 7);
            return;
        }

        // 8-10th check
        for ($i = 0; $i < count($rows); ++$i) {
            $sumFields = 0;
            $previousWasNumber = false;
            for ($k = 0; $k < strlen($rows[$i]); ++$k) {
                if (ctype_digit(substr($rows[$i], $k, 1))) {
                    // 8th criterion: every row is valid
                    if ($previousWasNumber) {
                        $this->addViolation($constraint, 8);
                        return;
                    }
                    $sumFields += intval(substr($rows[$i], $k, 1), 10);
                    $previousWasNumber = true;
                } else {
                    // 9th criterion: check symbols of piece
                    if (strpos(self::ALLOWED_PIECES_SYMBOLS, substr($rows[$i], $k, 1)) === false) {
                        $this->addViolation($constraint, 9);
                        return;
                    }
                    ++$sumFields;
                    $previousWasNumber = false;
                }
            }
            // 10th criterion: check sum piece + empty square must be 8
            if ($sumFields !== 8) {
                $this->addViolation($constraint, 10);
                return;
            }
        }


        // 11th criterion: en-passant if last is black's move, then its must be white turn
        if (strlen($tokens[3]) > 1) {
            if ((substr($tokens[3], 1, 1) == '3' && $tokens[1] == 'w') ||
                (substr($tokens[3], 1, 1) == '6' && $tokens[1] == 'b')) {
                $this->addViolation($constraint, 11);
                return;
            }
        }
    }

    private function addViolation(FenString $constraint, $errorNumber)
    {
        $this->context->buildViolation($constraint->messages[$errorNumber])
            ->addViolation();
    }
}

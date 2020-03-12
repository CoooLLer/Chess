<?php

namespace App\Interfaces;

interface ChessPieceInterface
{
    public function setColor($color): void;

    public function getColor(): string;

    public function getSymbol(): string;

    public function getOffsets(): array;

    public function getShift(): int;
}
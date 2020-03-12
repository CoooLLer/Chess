<?php

namespace App\Traits;

trait ChessPieceTrait
{
    private string $color;

     /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol[$this->getColor()];
    }

    /**
     * @return mixed
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    /**
     * @return array
     */
    public function getOffsets(): array
    {
        return self::OFFSETS;
    }

    public function getShift(): int
    {
        return $this->shift;
    }
}
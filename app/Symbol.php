<?php

namespace App;

class Symbol
{
    /** @var string */
    protected $symbol;

    /** @var string */
    protected $number;

    public function __construct(string $symbol, int $number)
    {
        $this->symbol = $symbol;
        $this->number = $number;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getNumber(): int
    {
        return $this->number;
    }
}

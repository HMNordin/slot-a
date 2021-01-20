<?php

namespace App;

use App\Contracts\RandomizerContract;
use Illuminate\Support\Collection;

class SymbolCollection
{
    const COLUMN_COUNT = 5;

    const NUMBERING = [
        0,
        3,
        6,
        9,
        12,
    ];

    /** @var Collection */
    protected $columns;

    public function __construct()
    {
        $this->columns = collect();
    }

    public function addColumn(Symbol $symbol): void
    {
        $this->columns->add($symbol);
    }

    public function getColumns(): Collection
    {
        return $this->columns;
    }

    public function generate(RandomizerContract $randomizer, int $row, int $amount = self::COLUMN_COUNT): void
    {
        for ($i = 0; $i < $amount; $i++) {
            $random = $randomizer->getRandom()->first();
            $this->addColumn(new Symbol($random, $this->getNumber($i, $row)));
        }
    }

    protected function getNumber(int $column, int $row): int
    {
        return self::NUMBERING[$column] + $row;
    }

    public function find(int $number): ?Symbol
    {
        return $this->columns->filter(function (Symbol $symbol) use ($number) {
            return $symbol->getNumber() === $number;
        })->first();
    }

    public function toArray(): array
    {
        return $this->getColumns()->map(function (Symbol $symbol) {
            return $symbol->getSymbol() . " pos ". $symbol->getNumber();
        })->toArray();
    }
}

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

    /** @var int */
    protected $row;

    public function __construct(int $row)
    {
        $this->row = $row;
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

    public function generate(RandomizerContract $randomizer, int $amount = self::COLUMN_COUNT): void
    {
        for ($i = 0; $i < $amount; $i++) {
            $random = $randomizer->getRandom()->first();
            $this->addColumn(new Symbol($random, $this->getNumber($i)));
        }
    }

    protected function getNumber(int $column): int
    {
        return self::NUMBERING[$column] + $this->row;
    }

    public function toArray(): array
    {
        return $this->getColumns()->map(function (Symbol $symbol) {
            return $symbol->getSymbol();
        })->toArray();
    }
}

<?php

namespace App;

use App\Contracts\RandomizerContract;
use Illuminate\Support\Collection;

class SymbolCollection
{
    const COLUMN_COUNT = 5;

    /**
     * Used as a base to calculate each symbols number
     */
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

    public function getColumns(): Collection
    {
        return $this->columns;
    }

    /**
     * Generates random symbols that it numbers and puts into the columns collection
     * this way we wrap all the symbols into our own collection class
     *
     * @param RandomizerContract $randomizer
     * @param int $row
     * @param int $amount
     */
    public function generate(RandomizerContract $randomizer, int $row, int $amount = self::COLUMN_COUNT): void
    {
        for ($i = 0; $i < $amount; $i++) {
            $random = $randomizer->getRandom()->first();
            $this->columns->add(new Symbol($random, $this->getNumber($i, $row)));
        }
    }

    /**
     * Returns the "coordinates" for the Symbol based on column and row
     *
     * @param int $column
     * @param int $row
     * @return int
     */
    protected function getNumber(int $column, int $row): int
    {
        return self::NUMBERING[$column] + $row;
    }

    /**
     * Searches the collection for the given symbol number and returns the Symbol
     * if found
     *
     * @param int $number
     * @return Symbol|null
     */
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

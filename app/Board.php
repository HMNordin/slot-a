<?php

namespace App;

use Illuminate\Support\Collection;

class Board
{
    /** @var Collection */
    protected $rows;

    public function __construct()
    {
        $this->rows = collect();
    }

    public function addRow(SymbolCollection $symbolCollection): void
    {
        $this->rows->add($symbolCollection);
    }

    public function getRows(): Collection
    {
        return $this->rows;
    }

    public function toArray(): array
    {
        return $this->getRows()->map(function (SymbolCollection $rows) {
           return $rows->toArray();
        })->toArray();
    }
}

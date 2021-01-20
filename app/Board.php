<?php

namespace App;

use Illuminate\Support\Collection;

class Board
{
    const WIN_RATIO = [
        3 => 0.20,
        4 => 2,
        5 => 10,
    ];

    /** @var SymbolCollection */
    protected $symbolsCollection;

    /** @var Collection */
    protected $matched;

    /** @var int */
    protected $winnings = 0;

    public function __construct()
    {
        $this->matched = collect();
    }

    public function setSymbolCollection(SymbolCollection $symbolCollection): void
    {
        $this->symbolsCollection = $symbolCollection;
    }

    public function getSymbolCollection(): SymbolCollection
    {
        return $this->symbolsCollection;
    }

    public function getWin(): int
    {
        return $this->winnings;
    }

    public function getMatchedPaylines(): Collection
    {
        return $this->matched;
    }

    public function bet(array $paylines, int $bet): void
    {
        foreach ($paylines as $payline) {
            $matched = $this->findMatch($payline);
            if ($matched >= 3) {
                $this->matched->add([
                    implode(',', $payline) => $matched,
                ]);

                $this->winnings += $this->calculateWin($bet, $matched);
            }
        }
    }

    protected function calculateWin(int $bet, int $matched): int
    {
        return self::WIN_RATIO[$matched] * $bet;
    }

    protected function findMatch(array $payline): int
    {
        $prevSymbol = $this->symbolsCollection->find($payline[0])->getSymbol();
        $matchCount = 1;

        // Remove first element becuase we use to set the preSymbol already counts as 1 match
        array_shift($payline);

        foreach ($payline as $number) {
            $symbol = $this->symbolsCollection->find($number);

            $symbol = $symbol->getSymbol();

            if ($prevSymbol === $symbol) {
                $matchCount++;
            } else {
                $prevSymbol = null;
            }
        }

        return $matchCount;
    }

    public function toArray(): array
    {
        return $this->getSymbolCollection()->toArray();
    }
}

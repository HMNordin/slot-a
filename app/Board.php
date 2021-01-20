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

    /**
     * If we get enough symbols that match we add the result
     * to the matched collection and add our winnings to the board
     *
     * @param array $paylines
     * @param int $bet
     * @return $this
     */
    public function bet(array $paylines, int $bet): self
    {
        foreach ($paylines as $payline) {
            $matched = $this->findMatch($payline);
            $this->matched->add([
                implode(',', $payline) => $matched,
            ]);

            $this->winnings += $this->calculateWin($bet, $matched);
        }

        return $this;
    }

    /**
     * Returns the win amount based on the WIN_RATIO set in the const
     * this could be changed in the future or moved into DB for example
     *
     * @param int $bet
     * @param int $matched
     * @return int
     */
    protected function calculateWin(int $bet, int $matched): int
    {
        if ($matched < 3) {
            return 0;
        }

        return self::WIN_RATIO[$matched] * $bet;
    }

    /**
     * Finds matches based on the payline given, search through
     * the symbolsCollection for the number in the payline array
     * if we find subsequent matches we return the amount of matched symbols
     *
     * @param array $payline
     * @return int
     */
    protected function findMatch(array $payline): int
    {
        $prevSymbol = $this->symbolsCollection->find($payline[0])->getSymbol();
        $matchCount = 1;

        // Remove first element because we use to set the preSymbol already counts as 1 match
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

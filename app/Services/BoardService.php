<?php

namespace App\Services;

use App\Board;
use App\Contracts\RandomizerContract;
use App\SymbolCollection;

class BoardService
{
    const ROW_COUNT = 3;

    /** @var RandomService */
    private $randomizeService;

    /** @var Board */
    private $board;

    public function __construct(RandomizerContract $randomizeService)
    {
        $this->randomizeService = $randomizeService;
        $this->board = new Board();
    }

    public static function make(): self
    {
        return app(self::class);
    }

    public function generate(int $amount = self::ROW_COUNT): self
    {
        $symbolCollection = new SymbolCollection();

        for ($i = 0; $i < $amount; $i++) {
            $symbolCollection->generate($this->randomizeService, $i);
        }

        $this->board->setSymbolCollection($symbolCollection);

        return $this;
    }

    public function getBoard(): Board
    {
        return $this->board;
    }
}

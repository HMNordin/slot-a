<?php

namespace App\Services;

use App\Contracts\RandomizerContract;
use Illuminate\Support\Collection;

class RandomService implements RandomizerContract
{
    /** @var Collection */
    protected $items;

    public function __construct(string $items)
    {
        $this->items = collect(explode(',', $items));
    }

    public function getRandom(int $amount = 1): Collection
    {
        return $this->items->random($amount);
    }
}

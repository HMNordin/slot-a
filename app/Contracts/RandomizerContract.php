<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface RandomizerContract
{
    /**
     * This returns a random collection of items based on what is
     * injected by the container. This was done so that we can easily
     * mock this or interchange the randomizer for other games.
     *
     * @param int $amount
     * @return Collection
     */
    public function getRandom(int $amount = 1): Collection;
}

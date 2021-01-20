<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface RandomizerContract
{
    public function getRandom(int $amount = 1): Collection;
}

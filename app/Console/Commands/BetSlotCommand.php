<?php

namespace App\Console\Commands;

use App\Services\BoardService;
use Illuminate\Console\Command;

class BetSlotCommand extends Command
{
    const PAYLINES = [
        [0, 3, 6, 9, 12],
        [1, 4, 7, 10, 13],
        [2, 5, 8, 11, 14],
        [0, 4, 8, 10, 12],
        [2, 4, 6, 10, 14],
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate board';

    public function handle()
    {
        $boardService = BoardService::make()->generate();
        $bet = 100;

        $board = $boardService->getBoard()->bet(self::PAYLINES, $bet);

        $response = [
            'board' => $board->toArray(),
            'paylines' => $board->getMatchedPaylines()->toArray(),
            'bet_amount' => $bet,
            'total_win' => $board->getWin(),
        ];

        $this->info(json_encode($response, JSON_PRETTY_PRINT));
    }
}

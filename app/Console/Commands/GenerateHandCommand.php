<?php

namespace App\Console\Commands;

use App\Services\BoardService;
use App\Symbol;
use App\SymbolCollection;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateHandCommand extends Command
{
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
        $boardService = BoardService::make();
        $boardService->generate();

        $board = $boardService->getBoard();

        $response = [
            'board' => Arr::flatten($board->toArray()),
        ];

        $this->info(json_encode($response));
    }
}

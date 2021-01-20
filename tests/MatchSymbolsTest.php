<?php

use App\Contracts\RandomizerContract;
use App\Services\BoardService;
use App\Services\RandomService;
use Mockery\MockInterface;

class MatchSymbolsTest extends TestCase
{
    /**
     * Added test to show how I would write test, obviously more tests would be required here
     */
    public function testWinIsCorrectOnMatchFive()
    {
        $this->app->instance(
            RandomizerContract::class,
            Mockery::mock(RandomService::class, function (MockInterface $mock) {
                $mock->shouldReceive('getRandom')->andReturn(collect(['J']));
            })
        );

        $boardService = BoardService::make()->generate();

        $board = $boardService->getBoard()->bet([[0, 3, 6, 9, 12]], 100);

        $this->assertEquals(1000, $board->getWin());
    }
}

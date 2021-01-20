<?php

use App\Contracts\RandomizerContract;
use App\Services\BoardService;
use App\Services\RandomService;
use Mockery\MockInterface;

/**
 * Added test to show how I would write test, obviously more tests would be required here
 */
class MatchSymbolsTest extends TestCase
{
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

    public function testWinIsCorrectOnMatchFour()
    {
        $this->app->instance(
            RandomizerContract::class,
            Mockery::mock(RandomService::class, function (MockInterface $mock) {
                $mock->shouldReceive('getRandom')->andReturn(collect(['J']), collect(['J']), collect(['J']), collect(['J']), collect(['X']));
            })
        );

        $boardService = BoardService::make()->generate();

        $board = $boardService->getBoard()->bet([[0, 3, 6, 9, 12]], 100);

        $this->assertEquals(200, $board->getWin());
    }

    public function testWinIsCorrectOnMatchThree()
    {
        $this->app->instance(
            RandomizerContract::class,
            Mockery::mock(RandomService::class, function (MockInterface $mock) {
                $mock->shouldReceive('getRandom')->andReturn(collect(['J']), collect(['J']), collect(['J']), collect(['B']), collect(['X']));
            })
        );

        $boardService = BoardService::make()->generate();

        $board = $boardService->getBoard()->bet([[0, 3, 6, 9, 12]], 100);

        $this->assertEquals(20, $board->getWin());
    }

    public function testWinIsCorrectOnMatchTwo()
    {
        $this->app->instance(
            RandomizerContract::class,
            Mockery::mock(RandomService::class, function (MockInterface $mock) {
                $mock->shouldReceive('getRandom')->andReturn(collect(['J']), collect(['J']), collect(['A']), collect(['B']), collect(['X']));
            })
        );

        $boardService = BoardService::make()->generate();

        $board = $boardService->getBoard()->bet([[0, 3, 6, 9, 12]], 100);

        $this->assertEquals(0, $board->getWin());
    }
}

<?php

namespace Tests\Unit;

use App\Services\LuckyGame;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LuckyGameTest extends TestCase
{
    #[DataProvider('numbers')]
    public function test_result_for(int $number, bool $isWin, float $amount): void
    {
        $result = (new LuckyGame())->resultFor($number);

        $this->assertSame($number, $result['number']);
        $this->assertSame($isWin, $result['is_win']);
        $this->assertSame($amount, $result['win_amount']);
    }

    public static function numbers(): array
    {
        return [
            'even <=300 -> 10%' => [300, true, 30.0],
            'even >300 -> 30%'  => [302, true, 90.6],
            'boundary 600 -> 30%' => [600, true, 180.0],
            'even >600 -> 50%'  => [602, true, 301.0],
            'boundary 900 -> 50%' => [900, true, 450.0],
            'even >900 -> 70%'  => [902, true, 631.4],
            'max 1000 -> 70%'   => [1000, true, 700.0],
            'small even -> 10%' => [2, true, 0.2],
            'odd -> lose'       => [301, false, 0.0],
            'min odd -> lose'   => [1, false, 0.0],
        ];
    }

    public function test_play_returns_number_in_range(): void
    {
        $result = (new LuckyGame())->play();

        $this->assertGreaterThanOrEqual(1, $result['number']);
        $this->assertLessThanOrEqual(1000, $result['number']);
    }
}

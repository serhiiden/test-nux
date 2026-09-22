<?php

namespace App\Services;

class LuckyGame
{
    public function play(): array
    {
        return $this->resultFor(random_int(1, 1000));
    }

    public function resultFor(int $number): array
    {
        $isWin = $number % 2 === 0;

        $percent = match (true) {
            $number > 900 => 0.7,
            $number > 600 => 0.5,
            $number > 300 => 0.3,
            default => 0.1,
        };

        return [
            'number' => $number,
            'is_win' => $isWin,
            'win_amount' => $isWin ? round($number * $percent, 2) : 0.0,
        ];
    }
}

<?php

namespace Tests\Feature;

use App\Models\AccessLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    private function makeLink(): AccessLink
    {
        return User::factory()->create()->accessLink()->create([
            'token' => str_repeat('a', 64),
            'expires_at' => now()->addDays(7),
        ]);
    }

    public function test_play_stores_result_and_shows_it(): void
    {
        $link = $this->makeLink();

        $response = $this->followingRedirects()
            ->post(route('page-a.play', $link->token));

        $result = $link->user->gameResults()->sole();

        $this->assertGreaterThanOrEqual(1, $result->number);
        $this->assertLessThanOrEqual(1000, $result->number);
        $this->assertSame($result->number % 2 === 0, $result->is_win);

        $response->assertOk()
            ->assertSee('Result')
            ->assertSee($result->is_win ? 'Win' : 'Lose');
    }

    public function test_history_shows_last_three_results(): void
    {
        $link = $this->makeLink();

        foreach ([100, 200, 300, 400] as $number) {
            $link->user->gameResults()->create([
                'number' => $number,
                'is_win' => true,
                'win_amount' => 1,
            ]);
        }

        $this->get(route('page-a.history', $link->token))
            ->assertOk()
            ->assertSee('Number: 400')
            ->assertSee('Number: 300')
            ->assertSee('Number: 200')
            ->assertDontSee('Number: 100');
    }

    public function test_play_requires_valid_link(): void
    {
        $this->post('/a/unknown-token/play')->assertNotFound();
    }
}

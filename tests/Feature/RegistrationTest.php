<?php

namespace Tests\Feature;

use App\Models\AccessLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_form_is_shown(): void
    {
        $this->get('/')->assertOk()->assertSee('Register');
    }

    public function test_user_registers_and_gets_unique_link(): void
    {
        $response = $this->post('/register', [
            'username' => 'john',
            'phone_number' => '+380501234567',
        ]);

        $user = User::sole();
        $link = AccessLink::sole();

        $this->assertSame('john', $user->username);
        $this->assertSame($user->id, $link->user_id);
        $this->assertTrue($link->is_active);
        $this->assertTrue($link->expires_at->isSameDay(now()->addDays(7)));
        $response->assertRedirect(route('page-a.show', $link->token));
    }

    public function test_registration_requires_valid_fields(): void
    {
        $this->from('/')
            ->post('/register', ['username' => '', 'phone_number' => 'abc'])
            ->assertRedirect('/')
            ->assertSessionHasErrors(['username', 'phone_number']);

        $this->assertDatabaseCount('users', 0);
    }
}

<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSeeLivewire('pages.auth.register');
    }

    /**
     * @test
     */
    public function new_users_can_register(): void
    {
        $component = Livewire::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password');

        $component->call('register');

        $component->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    }
}

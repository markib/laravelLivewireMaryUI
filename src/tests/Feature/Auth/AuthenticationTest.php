<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function login_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin');

        // $response
        //     ->assertOk()
        //     ->assertSeeVolt('pages.auth.login');
        $response->assertStatus(200);
        $response->assertSee('Login');

    }

    /**
     * @test
     */
    public function users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();
        // dd(Blade::getClassComponentAliases());

        $component = Livewire::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'password');
        // dd($component);

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    }

    /**
     * @test
     */
    public function users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $component = Livewire::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'wrong-password');

        $component->call('login');

        $component
            ->assertHasErrors()
            ->assertNoRedirect();

        $this->assertGuest();
    }

    /**
     * @test
     */
    public function navigation_menu_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response
            ->assertOk()
            ->assertSeeLivewire('layout.navigation');
    }

    /**
     * @test
     */
    public function users_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Livewire::test('layout.navigation');

        $component->call('logout');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/admin');

        $this->assertGuest();
    }
}

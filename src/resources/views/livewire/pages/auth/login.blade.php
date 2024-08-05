<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
};

?>

<div>
    <!-- Session Status -->
    <x-auth-session-status  :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <!-- <x-input-label for="email" :value="__('Email')" /> -->
            <x-mary-input  icon="o-user" label="Email" wire:model="form.email" id="email"  type="email"  placeholder="Email"  required autofocus autocomplete="username" />
        </div>
        <!-- Password -->
            <!-- <x-input-label for="password" :value="__('Password')" /> -->
        <div>
            <x-mary-input class="block mt-1 w-full" label="Password" wire:model="form.password" id="password" icon="o-eye" type="password" placeholder="*******"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
      </div>
        <!-- Remember Me -->
        <div>
            <x-mary-checkbox class="inline-flex items-center" label="Remember me" id="remember" wire:model="form.remember" />
            <!-- <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label> -->
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif
<x-mary-button class="" label="Log in" class="btn-primary" type="submit" spinner="save" />
            <!-- <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button> -->
        </div>
    </form>
</div>

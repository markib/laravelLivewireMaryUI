<?php

use function Livewire\Volt\{state};

state('count');

$increment = function () {
    // Store the new count value in the database...

    $this->count++;
};

?>

<x-app-layout>
    <x-slot name="header">
        Initial value: {{ $count }}
    </x-slot>

    @volt('counter')
    <div>
        <h1>{{ $count }}</h1>
        <button wire:click="increment">+</button>
    </div>
    @endvolt
</x-app-layout>
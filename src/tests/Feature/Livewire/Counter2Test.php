<?php

use Livewire\Volt\Volt;

it('can render', function () {
    Volt::test('counter2')
        ->assertSee('0')
        ->call('increment')
        ->assertSee('1');
});

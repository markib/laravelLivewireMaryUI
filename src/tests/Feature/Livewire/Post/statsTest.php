<?php

use Livewire\Livewire;
use Livewire\Volt\Volt;

it('can render', function () {
 
    $component = Livewire::test('post\stats');

    $component->assertSee('Posts');
});

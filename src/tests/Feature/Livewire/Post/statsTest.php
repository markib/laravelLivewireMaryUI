<?php

use Livewire\Volt\Volt;

it('can render', function () {
 
    $component = Volt::test('post\stats');

    $component->assertSee('Posts');
});

<?php

use Livewire\Volt\Volt;

it('can render', function () {
    $component = Volt::test('product\product-index');

    $component->assertSee('');
});

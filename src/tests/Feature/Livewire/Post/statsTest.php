<?php

use Livewire\Livewire;

it('can render', function () {

    $component = Livewire::test('post.stats');

    $component->assertSee('Posts');
});

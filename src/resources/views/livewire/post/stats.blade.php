<?php

use App\Models\Post;
use Livewire\Volt\Component;
// use function Livewire\Volt\{state};


new class extends Component
{

    public function with(): array
    {
        return [
            'posts' => Post::query()->count(),
        ];
    }
}; ?>
<section id="stats" aria-labelledby="stats" class="grid grid-cols-4 gap-4">
    <x-mary-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" />

    <x-mary-stat title="Posts" description="" value="{{ $posts }}" icon="o-arrow-trending-up" tooltip-bottom="post" class="col-span-2" />

    {{-- <x-mary-stat title="Lost" description="This month" value="34" icon="o-arrow-trending-down" tooltip-left="Ops!" /> --}}

    {{-- <x-mary-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-down" class="text-orange-500" color="text-pink-500" tooltip-right="Gosh!" /> --}}
</section>
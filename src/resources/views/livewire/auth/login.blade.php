<?php

use Livewire\Volt\Component;
use function Livewire\Volt\{layout};


new class extends Component {
    //
    public $email = '';
    public $password = '';
    public $remember_me = false;

  
}; ?>

<div>
    <x-form wire:submit="save">
<x-input label="Username" placeholder="Username" icon="o-user" hint="" />
<x-input label="Password"  type="password" icon="o-key" hint="" />
    <x-slot:actions>
        <x-button label="Register" />
        <x-button label="Login" class="btn-primary" type="submit" spinner="save" />
    </x-slot:actions>
</x-form>
</div>

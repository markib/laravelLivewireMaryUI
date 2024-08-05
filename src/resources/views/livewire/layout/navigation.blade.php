<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;

$logout = function (Logout $logout) {
    $logout();
        Auth::logout();
    $this->redirect('/admin');
};

?>


<div>   
    
   <!-- Authentication -->
                <!-- <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button> -->

               
                        <x-mary-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" wire:click="logout" spinner/>
                

</nav>

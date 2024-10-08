<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Livewire\Attributes\Validate;

class Chat extends Component
{
    #[Validate('required|max:1000')]
    public string $body = '';

    public array $messages = [];

    public function mount()
    {
        $this->messages[] = ['role' => 'system', 'content' => 'You are a friendly web developer here to help.'];
    }

    public function send()
    {
        $this->validate();

        $this->messages[] = ['role' => 'user', 'content' => $this->body];
        $this->messages[] = ['role' => 'assistant', 'content' => ''];

        $this->body = '';
    }

    public function render()
    {
        return view('livewire.chat.chat');
    }
}

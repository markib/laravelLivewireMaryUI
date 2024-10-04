<?php

namespace App\Livewire\Chat;

use Gemini;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ChatBot extends Component
{
    public $prompt = '';

    public $question = '';

    public $answer = '';

    public array $messages;


    public ?string $response = null;
    
    

    public function mount()
    {
        // $this->response = $response;
       $this->js('$wire.ask()');
    }

    function submitPrompt()
    {
        $this->question = $this->prompt;

        $this->prompt = '';

        $this->js('$wire.ask()');
    }

    function ask()
    {
// dd($this->messages);
    //   Log::notice($this->messages);
        foreach($this->messages as $key => $message){
              if ($message['role'] === 'user'){
        $geminiApiKey = getenv('GEMINI_API_KEY'); 
        $client = Gemini::client($geminiApiKey);
        $response = $client->geminiPro()
        ->streamGenerateContent($message['content']);
              }
        }
        foreach ($response as $key=>$partial) {
            // $this->answers[] = ['key' => $key, 'text' => $partial->text() ,'question' => $this->question,];
            
            $this->response .= $partial->text();
            $this->stream(to: 'answer-'. $this->getId() , content: $partial->text() ,replace:false);
           
            // $this->answer .= $this->stream('answer', $partial->text());
            sleep(1);
 
        }
    }

  
    
    public function render()
    {
        return view('livewire.chat.chat-bot');
    }


}

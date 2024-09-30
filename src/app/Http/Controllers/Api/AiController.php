<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Gemini;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class AiController extends Controller
{
    public function index(Request $input)
    {
        
        // if ($input->title == null) {
        //     return;
        // }

        $title = "test";


        try {
        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            "max_tokens" => 50,
            'messages' => [
                ['role' => 'user', 'content' => 'Hello!'],
            ],
        ]);
            $content = trim($result['choices'][0]['text']);
            return $content;
        } catch (\OpenAI\Exceptions\ErrorException $e) {
            echo "Error: " . $e->getMessage();
            // Optionally, log the error or notify the user.
        }
       
    
    }

    public function geminiPrompt(Request $request){
        $geminiApiKey = getenv('GEMINI_API_KEY');
        $client = Gemini::client($geminiApiKey);

        $result = $client->geminiPro()->generateContent('Hello Google');

       return  $result->text(); // Hello! How can I assist you today?
    }
}

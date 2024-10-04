<?php

namespace App\Livewire;

use Gemini;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;


class ReceiptScanner extends Component
{

    use WithFileUploads;

    public $receipt;
    public $extractedData;
    public $error = '';
    public $loading = false;

    public function extract()
    {
        
        $this->error = '';
        $this->validate([
            'receipt' => 'required|image|max:1024', // max 1MB
        ]);

        $this->loading = true;
        $image = file_get_contents($this->receipt->getRealPath());
        $encodedImage = base64_encode($image);
        $prompt = "Extract the following information from this receipt image: date, total amount, merchant name, and list of items purchased with their prices. Respond in JSON format.";
        $geminiApiKey = getenv('GEMINI_API_KEY');
        if (!$geminiApiKey) {
            throw new \Exception('API key not set.');
        }
        try
        {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-goog-api-key' => getenv('GEMINI_API_KEY'),
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent', [
            'contents' => [
                'parts' => [
                    [
                        'text' => $prompt
                    ],
                    [
                        'inline_data' => [
                            'mime_type' => 'image/jpeg',
                            'data' => $encodedImage
                        ]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
                $extractedText = $responseData['candidates'][0]['content']['parts'][0]['text'];

                // Extract the JSON part from the response
                preg_match('/```json(.*)```/s', $extractedText, $matches);
                $jsonString = isset($matches[1]) ? trim($matches[1]) : $extractedText;

                $this->extractedData = json_decode($jsonString, true);
            
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->extractedData = ['error' => 'Failed to parse JSON response'];
                }
        } else {
                Log::error('API Request failed: ' . $response->status());
                Log::error('Reason: ' . $response->body());
            $this->extractedData = 'Error: Unable to identify the plant.';
        }
        } catch (\Exception $e) {
            $this->error = 'An unexpected error occurred. Please try again.';
        }
        $this->loading = false;
    }
    public function render()
    {
        return view('livewire.receipt-scanner');
    }
}

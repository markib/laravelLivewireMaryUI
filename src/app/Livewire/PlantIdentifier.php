<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;


class PlantIdentifier extends Component
{
    use WithFileUploads;

    public $photo;
    public $result;
    public $loading = false;
    public $error = '';

    // public function mount()
    // {
    //     $this->js('$wire.upload()');
    // }
    protected $rules = [
        'photo' => 'required|image|max:1024', // 1MB Max
    ];

    public function updatedPhoto()
    {
        $this->validateOnly('photo');
    }

    public function save()
    {
        $this->error = '';
        $this->validate();

        $this->loading = true;
        try {
        $path = $this->photo->store('temp', 'public'); 
        $fullPath = storage_path('app/public/' . $path);

        $image = file_get_contents($fullPath);
        $base64Image = base64_encode($image);
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-goog-api-key' => getenv('GEMINI_API_KEY'),
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent', [
            'contents' => [
                'parts' => [
                    [
                        'text' => 'Identify this plant and provide its scientific name, common name, and a brief description.'
                    ],
                    [
                        'inline_data' => [
                            'mime_type' => 'image/jpeg',
                            'data' => $base64Image
                        ]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $this->result = $response->json()['candidates'][0]['content']['parts'][0]['text'];
        } else {
                Log::error('API Request failed: ' . $response->status());
                Log::error('Reason: ' . $response->body());
            $this->result = 'Error: Unable to identify the plant.';
        }
        } catch (\Exception $e) {
            $this->error = 'An unexpected error occurred. Please try again.';
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.plant-identifier');
    }
}

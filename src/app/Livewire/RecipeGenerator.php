<?php

namespace App\Livewire;

use App\Services\OllamaService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RecipeGenerator extends Component
{
    public $query = ''; // User input for recipe generation
    public $recipes = ''; // Generated recipes
    
    public $isLoading = false; // Loading state
    
    protected $ollamaService;

    public function boot(OllamaService $ollamaService)
    {
        $this->ollamaService = $ollamaService;
    }

    // Generate recipes
    public function generateRecipes()
    {

  

        $this->validate([
            'query' => 'required|min:3',
        ]);
        // Clear previous data
        // $this->reset(['recipes']);
        // $this->resetStream('recipes'); // Crucial: Reset the stream
        $this->recipes = '';
        
        
        $this->isLoading = true; // Show loading spinner
        // Log::info('Starting recipe generation.', ['query' => $this->query]);
        $this->processStream();
     
    }

    protected function processStream()
    {
        Log::info('Starting to process stream.');


        try {
            // Call the OllamaService for streaming
            
            $stream = $this->ollamaService->generate("Generate a recipe for: {$this->query}", 'deepseek-r1:1.5b');
          
            if ($stream) {
                // Log::info('Stream created successfully.');
                $buffer = '';
                
                while (!$stream->eof()) {
                    $chunk = $stream->read(1024); // Read a chunk of the response
                    $buffer .= $chunk;


                    while (($pos = strpos($buffer, "}\n")) !== false) {
                        $jsonChunk = substr($buffer, 0, $pos + 1);
                        $buffer = substr($buffer, $pos + 2);

                        $data = json_decode($jsonChunk, true);
                        if (json_last_error() === JSON_ERROR_NONE && isset($data['response'])) {
                            $newText = $this->filterTokens($data['response']);
                            $this->recipes .= $newText; 
                            // $this->fullText .= $newText;
                            // $this->dispatch('new-chunk', $newText);
                            $this->stream(to:'recipes', content: $newText, replace: false);
                        }
                    }
                }
                

            } else {
                // Log::error('Failed to create stream.');
                session()->flash('error', 'Failed to create stream. Please try again.');
                $this->isLoading = false;
            }
        } catch (\Exception $e) {
            // Handle errors
            $this->dispatch('new-chunk', 'Error: ' . $e->getMessage());
            // $this->addError('query', 'Failed to generate recipes. Please try again.');
            $this->isLoading = false;
        } finally {
            $this->isLoading = false;
        }

     
    }
    // Filter out unwanted tokens like <think>
    protected function filterTokens($text)
    {
        // Remove unwanted tokens like <think>
        return str_replace(['<think>', '</think>'], '', $text);
    }


    public function render()
    {
        return view('livewire.recipe-generator');
    }
}

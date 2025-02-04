<?php

namespace App\Services;

class OllamaService
{
    protected $apiUrl;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->apiUrl = env('OLLAMA_API_URL');
    }

    public function generate($prompt, $model = 'deepseek-r1:1.5b')
    {
        
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($this->apiUrl .'api/generate', [
                'json' => [
                    'model' => $model,
                    'prompt' => $prompt,
                    'stream' => true, // Enable streaming
                ],
                'stream' => true, // Enable streaming in Guzzle
            ]);
            // Decode the JSON response
            // $responseData = json_decode($response->getBody(), true);
            
            return $response->getBody();
            
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle request exception
            return ['error' => 'Request failed', 'message' => $e->getMessage()];
        } catch (\Exception $e) {
            // Handle general exception
            return ['error' => 'An error occurred', 'message' => $e->getMessage()];
        }
    }
}

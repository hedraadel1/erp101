<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class Gpt2Controller extends Controller
{
    public function index()
    {
        return view('gpt2');
    }

    public function generateResponse(Request $request)
    {
        $userInput = $request->input('user_input');
        $apiKey = config('services.openai.api_key');

        // Set up OpenAI with your API key
        OpenAI::setApiKey($apiKey);

        // Call the OpenAI API to generate a response
        $response = OpenAI::createCompletion([
            'engine' => 'text-davinci-002',
            'prompt' => $userInput,
            'max_tokens' => 50, // Adjust as needed
        ]);

        // Get the bot's response
        $botResponse = $response['choices'][0]['text'];

        // You can format the response as needed

        return response()->json(['bot_response' => $botResponse]);
    }

    public function index(): JsonResponse
    {
        $search = "laravel get ip address";
        $data = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
                  ])
                  ->post("https://api.openai.com/v1/chat/completions", [
                    "model" => "gpt-3.5-turbo",
                    'messages' => [
                        [
                           "role" => "user",
                           "content" => $search
                       ]
                    ],
                    'temperature' => 0.5,
                    "max_tokens" => 200,
                    "top_p" => 1.0,
                    "frequency_penalty" => 0.52,
                    "presence_penalty" => 0.5,
                    "stop" => ["11."],
                  ])
                  ->json();
        return response()->json($data['choices'][0]['message'], 200, array(), JSON_PRETTY_PRINT);
    }
    public function generateText(Request $request)
    {
        try {
            $inputText = $request->input('input_text');

            $response = Http::post('https://api.openai.com/v1/chat/completions', [
                'text' => $inputText,
            ]);

            $generatedText = $response->json()['generated_text'];

            return response()->json(['generated_text' => $generatedText]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error("Error in GPT-2 integration: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred during GPT-2 integration.']);
        }
    }
}
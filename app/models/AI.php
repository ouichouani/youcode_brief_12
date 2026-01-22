<?php

namespace App\Models;

use App\models\Roadmap;

class AI
{
    private static $apiKey;
    private static $model;
    private static $endpoint = "https://router.huggingface.co/v1/chat/completions";

    private static function init()
    {
        self::$apiKey = $_ENV['HF_TOKEN'] ?? getenv('HF_TOKEN');
        self::$model = $_ENV['HF_MODEL'] ?? getenv('HF_MODEL') ?: 'mistralai/Mistral-7B-Instruct-v0.3';
    }

    public static function generateResponse(string $message)
    {
        self::init();

        if (empty(self::$apiKey)) {
            return json_encode(['error' => 'Hugging Face Token not configured in .env file.']);
        }

        $messages = [
            ['role' => 'system', 'content' => 'You are a helpful and friendly AI assistant.']
        ];



        $messages[] = ['role' => 'user', 'content' => $message];


        $data = [
            'model' => self::$model,
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 500
        ];

        $ch = curl_init(self::$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . self::$apiKey
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            return json_encode(['error' => 'cURL Error: ' . $curlError]);
        }

        $responseData = json_decode($response, true);

        if ($httpCode !== 200) {
            $errorMessage = $responseData['error'] ?? 'Hugging Face API returned an error.';
            if (is_array($errorMessage)) {
                $errorMessage = json_encode($errorMessage);
            }
            return json_encode(['error' => 'Hugging Face API Error: ' . $errorMessage]);
        }

        return $responseData['choices'][0]['message']['content'] ?? '';
    }

    public function generateRoadmap(array $responses): string
    {
        self::init();
        
        if (empty(self::$apiKey)) {
            return "Error: Hugging Face Token not configured.";
        }

        $userData = "";
        foreach ($responses as $response) {
            $userData .= "- Question: " . ($response['question_text'] ?? 'N/A') . "\n";
            $userData .= "  Answer: " . ($response['answer_text'] ?? 'N/A') . "\n";
        }

        $prompt = "As an AI career and learning coach, generate a detailed learning roadmap for a user based on the following questionnaire responses:\n\n" . $userData . "\n\nThe roadmap should include:\n1. A clear goal statement.\n2. Key milestones with specific topics to learn.\n3. Estimated duration for each milestone.\n4. Recommended resources.\n\nFormat the output in clear Markdown with headers and bullet points.";

        $messages = [
            ['role' => 'system', 'content' => 'You are an expert learning path architect.'],
            ['role' => 'user', 'content' => $prompt]
        ];

        $data = [
            'model' => self::$model,
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 2000
        ];

        $ch = curl_init(self::$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . self::$apiKey
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return "Error: AI generation failed with status " . $httpCode;
        }

        $responseData = json_decode($response, true);
        return $responseData['choices'][0]['message']['content'] ?? 'Error: No response from AI.';
    }
    public function generateSkills(){

    }
    public function generatePlans(){

    }
    public function generateTasks(){

    }
    public function showOpportunities(){
        
    }
}

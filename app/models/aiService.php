<?php

namespace App\Models;

class AI
{
    private string $api_key;


    public function __construct(string $key)
    {
        $this->api_key = $key;
    }
    function loadEnv($path)
    {
        if (!file_exists($path))
            return;
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0)
                continue;
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            $value = trim($value, '"\'');
            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
    public function getInput()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $message = $input['message'] ?? '';
        $history = $input['history'] ?? [];

        if (empty($message)) {
            echo json_encode(['error' => 'Empty message.']);
            exit;
        }
        return $message;
    }


    public function callApi($model, $messages)
    {
        $url = "https://router.huggingface.co/v1/chat/completions";

        $data = [
            'model' => $model,
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 500
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->api_key
        ]);
        return $ch;
    }
    public function generateQuestions(): array
    {
        $prompt = "Generate 5 questions to assess a user's learning goals, level, and availability.";

        return $this->callAI($prompt);
    }

    public function generateRoadmap(array $answers): string
    {
        $prompt = "Create a learning roadmap based on these answers: " . json_encode($answers);

        return $this->callAI($prompt);
    }

    public function callAi(string $prompt): string|array
    {
        return [];
    }
}

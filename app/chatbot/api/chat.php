<?php

/**
 * Mini AI Chat API
 * Using native PHP cURL to avoid dependency version conflicts (PHP 8.0 support)
 */

use OpenAI\Responses\Threads\Runs\ThreadRunListResponse;

header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(E_ALL);

use App\Models\aiService;

$ai = new aiService($apiKey = $_ENV['HF_TOKEN'] ?? getenv('HF_TOKEN'));
// --- Simple .env Loader ---


$ai->loadEnv(__DIR__ . '/.env');


$model = $_ENV['HF_MODEL'] ?? getenv('HF_MODEL') ?: 'mistralai/Mistral-7B-Instruct-v0.3';

if (!$apiKey) {
    echo json_encode(['error' => 'Hugging Face Token not configured in .env file.']);
    exit;
}

// --- Get Input ---
$ai->getInput();



// --- Prepare Messages ---
$messages = [
    [
        'role' => 'system',
        'content' => 'You are a helpful and friendly AI assistant.'
    ]
];

foreach (array_slice($history, -10) as $msg) {
    $messages[] = $msg;
}
$messages[] = [
    'role' => 'user',
    'content' => $message
];

// --- Hugging Face API Call (cURL - OpenAI Compatible) ---


// Handle SSL issues if common in local XAMPP
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => 'cURL Error: ' . $error]);
    exit;
}

$responseData = json_decode($response, true);

if ($httpCode !== 200) {
    http_response_code($httpCode);
    $errorMessage = $responseData['error'] ?? 'Hugging Face API returned an error.';
    if (is_array($errorMessage)) {
        $errorMessage = json_encode($errorMessage);
    }
    echo json_encode(['error' => 'Hugging Face API Error: ' . $errorMessage]);
    exit;
}

$reply = $responseData['choices'][0]['message']['content'];

echo json_encode([
    'reply' => $reply,
    'history' => array_merge($history, [
        ['role' => 'user', 'content' => $message],
        ['role' => 'assistant', 'content' => $reply]
    ])
]);

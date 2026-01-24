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

    public static function generateRoadmap(array $questions, array $responses): string
    {
        self::init();

        if (empty(self::$apiKey)) {
            return "Error: Hugging Face Token not configured.";
        }

        $question_content = [];
        foreach ($questions as $q) {
            $question_content[] = $q['content'];
        }

        $responses_content = [];
        foreach ($responses as $r) {
            $responses_content[] = $r['content'];
        }

        // $userData = "";
        $userData = '\n -------------- QUESTION --------------\n';
        $userData .= implode('\n', $question_content);
        $userData .= '\n -------------- RESPONSES --------------\n';
        $userData .= implode('\n', $responses_content);


        // foreach ($responses as $response) {
        //     $userData .= "- Question: " . ($response['question_text'] ?? 'N/A') . "\n";
        //     $userData .= "  Answer: " . ($response['answer_text'] ?? 'N/A') . "\n";
        // }

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

    public static function generatePlan(string $roadmapContent, \DateTime $created_at)
    {
        $created_at = $created_at->format('Y-m-d H:i:s');
        $message = "
                You are an expert learning coach.

                Based strictly on the following roadmap step, generate a detailed daily study/work plan.

                ROADMAP STEP:
                $roadmapContent

                ROADMAP CREATED AT:
                $created_at

                REQUIREMENTS:
                - The plan must be only for TODAY.
                - Break the plan into 3–6 clear, actionable tasks.
                - Each task must include:
                • Objective
                • Concrete action to perform
                • Estimated time
                - Include 2–3 high-quality learning resources (articles, documentation, or tutorials).
                - The plan must directly support completing this roadmap step.
                - Avoid generic advice. Be specific and practical.

                OUTPUT FORMAT:
                Return the response in structured sections:
                1. Daily Objective
                2. Task List (numbered)
                3. Resources
                4. Expected Outcome
                ";

        return self::generateResponse($message);
    }

    public static function generateOpportunities(array $skills, string $roadmapContent, array $questions, array $answers)
    {
        $skillsText    = implode(', ', $skills);
        $questionsText = implode(' | ', $questions);
        $answersText   = implode(' | ', $answers);

        $message = "
            You are a senior market analyst and career strategist.

            Your task is to generate REALISTIC, CURRENT, and ACTIONABLE opportunities based on the user's profile.

            USER PROFILE
            -------------
            Skills:
            $skillsText

            Roadmap focus:
            $roadmapContent

            Questionnaire (what was asked):
            $questionsText

            User answers:
            $answersText

            OBJECTIVE
            ---------
            Identify 3 to 5 concrete opportunities the user could pursue RIGHT NOW.
            These can include:
            - Freelancing opportunities
            - Remote jobs
            - Micro-SaaS ideas
            - Digital products
            - Consulting services
            - Local or online business ideas

            Each opportunity MUST align with the user’s skills and roadmap.

            DATABASE CONSTRAINTS
            --------------------
            Each opportunity must be compatible with this table:

            (title, description, estimated_income, external_link, market_source)

            OUTPUT RULES
            ------------
            Return ONLY valid JSON.
            Do NOT add explanations.
            Do NOT wrap in markdown.

            FORMAT (strict):
            [
            {
                \"title\": \"...\",
                \"description\": \"Clear description of what the user would do and for whom\",
                \"estimated_income\": 0,
                \"external_link\": \"https://...\",
                \"market_source\": \"fiverr\" // MUST be one of: 'fiverr', 'upwork', 'saas', 'other'
            }
            ]

            QUALITY RULES
            -------------
            - Opportunities must be realistic and monetizable
            - estimated_income must be monthly USD estimate (number only)
            - external_link must be a relevant platform or example
            - Avoid generic ideas
            - Tailor ideas strictly to this user profile
            ";

        return self::generateResponse($message);
    }

    public function generateSkills(string $roadmapContent , string $plan_content) {
        // generate skills
    }
    public function generateTasks(string $roadmapContent , string $plan_content) {
        // generate Tasks
    }

}

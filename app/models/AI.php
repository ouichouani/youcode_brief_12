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

  /**
   * Core generation method with strict JSON enforcement
   */
  public static function generate(string $prompt, float $temperature = 0.7): string
  {
    self::init();

    if (empty(self::$apiKey)) {
      return json_encode(['error' => 'AI Configuration missing.']);
    }

    $messages = [
      ['role' => 'system', 'content' => 'You are a deterministic AI specialized in SaaS business automation. Output ONLY raw valid JSON. No markdown, no triple backticks, no explanations.'],
      ['role' => 'user', 'content' => $prompt]
    ];

    $data = [
      'model' => self::$model,
      'messages' => $messages,
      'temperature' => $temperature,
      'max_tokens' => 3000
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
      return json_encode(['error' => 'AI Service Error: ' . $httpCode]);
    }

    $responseData = json_decode($response, true);
    $content = $responseData['choices'][0]['message']['content'] ?? '{}';

    // Sanitize: strip potential markdown fences if model ignores system instructions
    $content = preg_replace('/^```json\s*|```$/m', '', $content);

    return trim($content);
  }

  /**
   * 1. Roadmap Generation Logic
   */
  public static function generateStandardRoadmap(array $userProfile, ?string $selectedOpportunity = null): string
  {
    $profileStr = json_encode($userProfile);
    $oppStr = $selectedOpportunity ? "Target Opportunity: $selectedOpportunity" : "General adaptive growth";

    $prompt = "Generate a professional income generation roadmap.
                   User Profile: $profileStr
                   $oppStr
                   
                   Return STRICT JSON:
                   {
                     \"roadmap_title\": \"string\",
                     \"target_income\": \"string\",
                     \"duration_weeks\": integer,
                     \"phases\": [
                       {
                         \"phase_title\": \"string\",
                         \"objective\": \"string\",
                         \"tasks\": [
                           {
                             \"day\": integer,
                             \"task_title\": \"string\",
                             \"description\": \"string\",
                             \"estimated_time_minutes\": integer,
                             \"skill\": \"string\",
                             \"deliverable\": \"string\"
                           }
                         ]
                       }
                     ]
                   }";

    return self::generate($prompt, 0.7);
  }

  /**
   * 2. Skill Extraction Engine
   */
  public static function extractSkills(string $roadmapJson): string
  {
    $prompt = "Extract all unique skills from this roadmap JSON. Categorize and assign levels.
                   Roadmap: $roadmapJson
                   
                   Return STRICT JSON:
                   {
                     \"skills\": [
                       {
                         \"name\": \"string\",
                         \"category\": \"Technical | Business | AI | Soft Skills\",
                         \"level\": \"Beginner | Intermediate | Advanced\",
                         \"description\": \"string\"
                       }
                     ]
                   }";

    return self::generate($prompt, 0.3);
  }

  /**
   * 3. Opportunity Matching
   */
  public static function matchOpportunities(array $skills): string
  {
    $skillsStr = implode(", ", array_column($skills, 'name'));
    $prompt = "Identify 5 REALISTIC online income opportunities (Upwork, Fiverr, Malt, LinkedIn, IndieHackers) for these skills: $skillsStr.
                   
                   Return STRICT JSON:
                   {
                     \"opportunities\": [
                       {
                         \"title\": \"string\",
                         \"type\": \"Freelance | Job | Business\",
                         \"required_skills\": [],
                         \"estimated_monthly_income\": \"string\",
                         \"platform\": \"string\",
                         \"url\": \"string\",
                         \"action_plan_summary\": \"string\"
                       }
                     ]
                   }";

    return self::generate($prompt, 0.7);
  }

  /**
   * 4. Daily Plan Adaptation
   */
  public static function adaptDailyPlan(array $currentPlan, array $userStatus): string
  {
    $planStr = json_encode($currentPlan);
    $statusStr = json_encode($userStatus);

    $prompt = "Regenerate the daily tasks based on user progress and blockers.
                   Current Plan: $planStr
                   User Status: $statusStr (completed tasks, blockers, updated time availability)
                   
                   Adjust difficulty and tasks automatically.
                   Return JSON matching the 'tasks' array structure from roadmap.";

    return self::generate($prompt, 0.5);
  }

  /**
   * 5. Content Moderation
   */
  public static function moderateContent(string $text): string
  {
    $prompt = "Analyze this forum post for toxicity, spam, or high value.
                   Text: \"$text\"
                   
                   Return JSON:
                   {
                     \"status\": \"approved | flagged | rejected\",
                     \"score\": 0.0-1.0,
                     \"is_high_value\": boolean,
                     \"reason\": \"string\"
                   }";

    return self::generate($prompt, 0.2);
  }
}

<?php

namespace app\controllers;

use App\Models\AI;
use App\Core\Controller;
use App\Models\Opportunity;
use App\Models\Roadmap;
use App\Models\Plan;
use App\Models\Skill;
use App\Models\User;
use App\Models\Questionnaire;
use App\Models\Task;
use Exception;
class Dashboard extends Controller
{

    private AI $AI;

    public function __construct()
    {
        $this->AI = new AI();
    }


    private function checkAuth()
    {
        if (!User::isAuthenticaded()) {
            header('Location: ' . APP_ROOT . '/login');
            exit;
        }
    }

    public function show()
    {
        try {
            $this->checkAuth();

            $user = User::getAuthUser();
            if (!$user) {
                header('Location: ' . APP_ROOT . '/login');
                exit;
            }

            // Fetch correct roadmap for the logged-in user
            $Roadmap = Roadmap::getRoadmap($user['id']);

            // Default values
            $plan = [];
            $skills = [];
            $progress = 0;

            if ($Roadmap) {
                // Check if Plan exists
                $plan = Plan::getPlan($user['id'], $Roadmap['id']);

                if (!empty($plan)) {
                    $skills = Skill::getSkills($user['id'], $Roadmap['id']);

                    // Fetch real tasks from database
                    $dbTasks = Task::getAll($user['id']);

                    // Decode roadmap content for the view structure
                    if (isset($Roadmap['content'])) {
                        $decoded = json_decode($Roadmap['content'], true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $Roadmap['structured_content'] = $decoded;
                        }
                    }

                    // Map completed status from DB tasks to structured content if needed, 
                    // or just pass dbTasks. I'll pass dbTasks.
                    $progress = $plan['completion_percentage'] ?? 0;
                    if (!empty($dbTasks)) {
                        $completed = count(array_filter($dbTasks, fn($t) => $t['status'] === 'completed'));
                        $progress = round(($completed / count($dbTasks)) * 100);
                    }
                }
            }

            $opportunities = Opportunity::getAll();

            $data = [
                "user" => $user,
                "roadmap" => $Roadmap,
                "plan" => $plan,
                "skills" => $skills,
                "dbTasks" => $dbTasks ?? [],
                "progress" => $progress,
                "opportunities" => $opportunities,
            ];

            $this->view('dashboard/dashboard', $data);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function createPlan()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $user = User::getAuthUser();
        if (!$user) {
            header("Location: /login");
            exit;
        }

        try {
            // 1. Generate Structured Roadmap (JSON)
            $questModel = new Questionnaire();
            $roadmapRaw = $questModel->generateRoadmapForUser($user['id']);
            $roadmapData = json_decode($roadmapRaw, true);

            if (json_last_error() !== JSON_ERROR_NONE || !isset($roadmapData['phases'])) {
                throw new Exception("Invalid Roadmap AI output. Ensure tokens and model are correct.");
            }

            // 2. Save Master Roadmap
            $roadmapId = Roadmap::saveRoadmap($user['id'], $roadmapRaw);
            if (!$roadmapId)
                throw new Exception("Persistence failure: Roadmap.");

            // 3. Skill Extraction Engine
            $skillsRaw = AI::extractSkills($roadmapRaw);
            $skillsData = json_decode($skillsRaw, true);

            if (isset($skillsData['skills'])) {
                foreach ($skillsData['skills'] as $skill) {
                    $cat = 'other';
                    if (isset($skill['category'])) {
                        $c = strtolower($skill['category']);
                        if (strpos($c, 'ai') !== false)
                            $cat = 'AI';
                        elseif (strpos($c, 'business') !== false)
                            $cat = 'business';
                        elseif (strpos($c, 'dev') !== false || strpos($c, 'tech') !== false)
                            $cat = 'dev';
                        elseif (strpos($c, 'marketing') !== false)
                            $cat = 'marketing';
                    }

                    Skill::create(
                        $user['id'],
                        (int) $roadmapId,
                        $skill['name'],
                        $skill['description'] ?? null,
                        $cat
                    );
                }
            }

            // 4. Create Plan & Tasks Tracking
            $planId = Plan::create($user['id'], (int) $roadmapId, "AI Generated Adaptive Plan");

            if ($planId) {
                foreach ($roadmapData['phases'] as $phase) {
                    foreach ($phase['tasks'] as $task) {
                        $taskDesc = $task['task_title'] . ": " . $task['description'];
                        Task::create($user['id'], (int) $planId, $taskDesc, $task['skill']);
                    }
                }
            }

            // 5. Opportunity Matching Engine
            $oppsRaw = AI::matchOpportunities($skillsData['skills'] ?? []);
            $oppsData = json_decode($oppsRaw, true);

            if (isset($oppsData['opportunities'])) {
                foreach ($oppsData['opportunities'] as $opp) {
                    $incomeStr = $opp['estimated_monthly_income'] ?? '0';
                    // Extract the first number found in the string (handles "2000-5000" -> 2000)
                    preg_match('/\d+/', str_replace([',', ' '], '', $incomeStr), $matches);
                    $income = isset($matches[0]) ? (int) $matches[0] : 0;

                    Opportunity::create(
                        $user['id'],
                        $opp['title'],
                        $opp['action_plan_summary'] . " (Platform: " . $opp['platform'] . ")",
                        $income,
                        $opp['type'] ?? 'other'
                    );
                }
            }

            header("Location: /dashboard");
            exit;

        } catch (Exception $e) {
            // Log for production, show for development
            echo "Generation Logic Error: " . $e->getMessage();
            exit;
        }
    }

    public function updateAdaptivePlan()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $user = User::getAuthUser();
        if (!$user)
            exit('Unauthorized');

        try {
            // Get current incomplete tasks
            $allTasks = Task::getAll($user['id']);
            $currentTasks = array_filter($allTasks, fn($t) => $t['status'] !== 'completed');

            // Get user current status (mocking this as it would come from a POST form usually)
            $userStatus = [
                'blocked' => $_POST['blocked_reason'] ?? 'none',
                'time_available' => $_POST['time_minutes'] ?? 120,
                'completed_count' => count(array_filter($allTasks, fn($t) => $t['status'] === 'completed'))
            ];

            $newTasksRaw = AI::adaptDailyPlan($currentTasks, $userStatus);
            $newTasks = json_decode($newTasksRaw, true);

            if ($newTasks && is_array($newTasks)) {
                // Delete existing incomplete tasks and replace with adaptive ones
                // (Pragmatic approach: only replace future tasks)
                foreach ($newTasks as $task) {
                    $desc = $task['task_title'] . ": " . $task['description'];
                    // Plan ID needs to be fetched
                    $roadmap = Roadmap::getRoadmap($user['id']);
                    if ($roadmap) {
                        $plan = Plan::getPlan($user['id'], $roadmap['id']);
                        if ($plan) {
                            Task::create($user['id'], (int) $plan['id'], $desc);
                        }
                    }
                }
            }

            header("Location: /dashboard");
        } catch (Exception $e) {
            echo "Adaptation Error: " . $e->getMessage();
        }
    }
}

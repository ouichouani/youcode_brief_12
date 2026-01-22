<?php

namespace App\Controllers;

use App\Models\Questionnaire;
use App\models\Roadmap;

class QuestionnaireController
{
    private Questionnaire $model;

    public function __construct()
    {
        $this->model = new Questionnaire();
    }

    public function askQuest()
    {
        $questions = $this->model->getAllQuest();
        $this->render('questionnaire/questionnaire', ['questions' => $questions]);
    }

    public function captureResponse()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? 1;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['responses'])) {
            $responses = $_POST['responses'];
            if ($this->model->saveResponse($userId, $responses)) {
                header("Location: /roadmap/generate");
                exit;
            }
        }

        $this->askQuest();
    }

    public function generateRoadmap()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? 1;
        $roadmapContent = $this->model->generateRoadmapForUser($userId);

        $roadmapModel = new Roadmap();
        $roadmapModel->saveRoadmap($userId, $roadmapContent);

        header("Location: /roadmap/show");
        exit;
    }

    protected function render($view, $data = [])
    {
        extract($data);
        ob_start();
        require dirname(__DIR__) . "/views/$view.php";
        $content = ob_get_clean();

        ob_start();
        require dirname(__DIR__) . "/views/layout/layout.php";
        $layout = ob_get_clean();

        echo str_replace('{{content}}', $content, $layout);
    }
}

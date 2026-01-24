<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Questionnaire;
use App\models\Roadmap;
use App\models\AI;
use App\Models\Plan;
use DateTime;

class QuestionnaireController extends Controller
{
    private Questionnaire $model;

    public function __construct()
    {
        $this->model = new Questionnaire();
    }

    public function askQuest()
    {
        $questions = $this->model->getAllQuest();
        $this->view("questionnaire/questionnaire", ['questions' => $questions]);
    }

    public function captureResponse()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if(!isset($_SESSION['user'])){
            $_SESSION['error'] = 'not authenticated' ;
            return ;
        }

        $userId = $_SESSION['user']['id'] ;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['responses'])) {
            $responses = $_POST['responses'];
            if ($this->model->saveResponse($userId, $responses)) {
                header("Location: " . APP_ROOT . "/roadmap/generate");
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

        if(!isset($_SESSION['user'])){
            $_SESSION['error'] = 'not authenticated' ;
            return ;
        }
        
        $userId = $_SESSION['user']['id'] ;

        $roadmapContent = $this->model->generateRoadmapForUser($userId);

        $roadmapModel = new Roadmap();
        $roadmapModel->saveRoadmap($userId, $roadmapContent);

        Plan::create() ;

        header("Location: " . APP_ROOT . "/roadmap/show");
        exit;
    }

    // protected function render($view, $data = [])
    // {
    //     extract($data);
    //     ob_start();
    //     require dirname(__DIR__) . "/views/$view.php";
    //     $content = ob_get_clean();

    //     ob_start();
    //     require dirname(__DIR__) . "/views/layout/layout.php";
    //     $layout = ob_get_clean();

    //     echo str_replace('{{content}}', $content, $layout);
    // }
}

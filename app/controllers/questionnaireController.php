<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Questionnaire;
use App\models\Roadmap;
use App\models\Answer;
use App\models\AI;
use App\Models\Plan;
use App\Models\User;

class QuestionnaireController extends Controller
{


    public function askQuest()
    {
        $questions = Questionnaire::getAll();
        $this->view("questionnaire/questionnaire", ['questions' => $questions]);
    }

    public function captureResponse()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if(!User::isAuthenticated()){
            $_SESSION['error'] = 'not authenticated' ;
            $this->view('user/login') ;
        }

        $userId = User::getAuthUser()['id'] ;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['responses'])) {
            $responses = $_POST['responses'];
            if (Answer::saveResponse($userId, $responses)) {
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


        if(!User::isAuthenticated()){
            $_SESSION['error'] = 'not authenticated' ;
            $this->view('user/login') ;
        }

        $userId = User::getAuthUser()['id'] ;
        $responses = Answer::getAll($userId) ;
        $questions = Questionnaire::getAll() ;

        $roadmapContent = AI::generateRoadmap($questions , $responses);
        
        // SAVE THE ROADMAP IN DATABAE
        Roadmap::saveRoadmap($userId , $roadmapContent) ;

        //GET ROADMAP FROM DATABASE
        $roadmap = Roadmap::getRoadmap($userId) ;

        // CREATE PLAN BASED ON ROADMAP
        Plan::create($userId , $roadmap) ;

        header("Location: " . APP_ROOT . "/roadmap/show");
        exit;
    }

}

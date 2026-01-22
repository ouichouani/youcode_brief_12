<?php

namespace App\Controllers;

use App\Models\Questionnaire;

class questionnaireController
{
    private Questionnaire $model;
    public function __construct()
    {
        $this->model = new Questionnaire();
    }


    public function askQuest()
    {
        $quest = $this->model->getAllQuest();
    }
    public function captureResponse()
    {
        if (isset($_POST['user_response'])) {
            $this->model->saveResponse($_POST['user_response']);
        }
    }
    public function renderRoadmap() {
        
    }
}

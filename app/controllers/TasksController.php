<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Task;
use App\models\User;



class tasksController extends Controller
{

    public function getAll()
    {
        $tasks = Task::getAll();
    }

    public function markAsDone($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            Task::markAsDone($id);
        }
    }
}

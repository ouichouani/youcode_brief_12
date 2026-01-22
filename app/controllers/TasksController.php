<?php

namespace App\controllers;

use App\core\Controller;
use App\models\tasks;
use App\models\User;



class tasksController extends Controller {

    public function getAll() {
        $tasks = tasks::getAll();
        $this->view('tasks/tasks', ['tasks' => $tasks]); 
    }

    public function markAsDone($id) {

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $id=$POST['id'];
        $tasks = tasks::markAsDone($id);
        $this->redirect('/tasks'); 
    }
       
    }

}

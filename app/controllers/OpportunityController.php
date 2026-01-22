<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Opportunity;
use App\models\User;



class OpportunityController extends Controller
{
    // public function showOp(){
    //     $this->view("opportinity/index");
    // }
    // List toutes les opportunities



    public function showAll()
    {
        $opportunities = Opportunity::getAll();
        $this->view("opportinity/index", ['opportunities' => $opportunities]);
    }

    // Voir details d'une opportunity
    public function show($id)
    {
        $opportunity = Opportunity::getById($id);
        // require_once __DIR__ . "/../views/opportinity/show.php";
    }



}

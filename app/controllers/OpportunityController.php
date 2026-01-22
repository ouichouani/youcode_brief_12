<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Opportunity;
use App\Models\User;



class OpportunityController extends Controller{
    // voir tout les opportunity 
    public function showAll()
    {
        $opportunities = Opportunity::getAll();
        $this->view("opportinity/index", ['opportunities' => $opportunities]);
    }

    // Voir details d'une opportunity
    public function show(){

        $id = $_GET['id'] ?? null;
        if($id) {
            $opportunity = Opportunity::getById($id);
            $this->view('opportunity/show', ['opportunity' => $opportunity]);
        } else {
            $this->redirect('/opportunities');
        }
    }



}

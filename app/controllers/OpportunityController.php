<?php

namespace App\controllers;

use App\Core\Controller;
use App\Models\Opportunity;
use App\Models\User;



class OpportunityController extends Controller
{

    public function showAll()
    {
        $opportunities = Opportunity::getAll();
        $this->view("opportinity/index", ['opportunities' => $opportunities]);
    }

    public function show($id)
    {
        $opportunity = Opportunity::getById($id);
        $this->view("opportinity/index", ['opportunities' => $opportunity]);

    }



}

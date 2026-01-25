<?php

namespace App\controllers;

use App\Core\Controller;
use App\Models\Opportunity;
use App\Models\User;



class OpportunityController extends Controller
{
    private function checkAuth()
    {
        if (!User::isAuthenticaded()) {
            header('Location: ' . APP_ROOT . '/login');
            exit;
        }
    }

    public function showAll()
    {
        $this->checkAuth();
        $opportunities = Opportunity::getAll();
        $this->view("opportinity/index", ['opportunities' => $opportunities]);
    }

    public function show($id)
    {
        $this->checkAuth();
        $opportunity = Opportunity::getById($id);
        $this->view("opportinity/show", ['opportunity' => $opportunity]);
    }
}

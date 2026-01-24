<?php

namespace App\Controllers ;

use App\Core\Controller;
use App\Models\Plan;
use App\Models\Roadmap;
use App\Models\User;

class PlanController extends Controller{

    public function generatePlan(){

        $user_id = User::getAuthUser()['id'] ;
        if(!$user_id) $this->view('user/login') ;

        $roadmap = Roadmap::getRoadmap($user_id) ;        
        Plan::create($user_id , $roadmap) ;
        header('location: ../dashboard') ;
        
    }
}
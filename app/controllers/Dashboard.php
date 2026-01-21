<?php



namespace app\controllers ;

use app\controllers\AI ;
use app\models\User ;

class Dashboard{

    // private AI $AI ; 
    // private User $user ; 


    public function __construct()
    {
        // $this->AI = new AI() ;
        // $this->user = User::getInstence() ;
    }


    public function showDashboard(){
        
        Plan::getPlane();

        User::getSkills() ;
        AI::getProgress() ;
        
        // ...
    }

    public function createPlan(){
        // ...
    }

    public function updatePlan(){
        // ...
    }

    public function getPlan(){
        // ...
    }

    public function getSkills(){
        // ...
    }

    public function getProgress(){
        // ...
    }

}
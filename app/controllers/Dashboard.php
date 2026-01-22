<?php



namespace app\controllers;

use App\Controllers\AI;
use App\Core\Controller;
use App\Core\Router;
use App\Models\Opportunity;
use App\Models\Roadmap;
use App\Models\Plan;
use App\Models\Skill;
use App\Models\User;

class Dashboard extends Controller
{

    // private AI $AI ; 
    // private User $user ; 


    public function __construct()
    {
        // $this->AI = new AI() ;
        // $this->user = User::getInstence() ;
    }


    public function show()
    {

        try {

            if (!isset($_SESSION['user'])) {
                echo $this->view("user/login");
                exit;
            }

            if (!User::isAuthenticaded()) throw new \Exception('not authenticated');

            $user = User::getAuthUser();
            if (!$user) throw new \Exception('somthing wrong in roadmap fetching');

            $Roadmap = Roadmap::getRoadmap($user['id']);
            if (!$Roadmap) throw new \Exception('somthing wrong in roadmap fetching');

            $plan = Plan::getPlane($user['id'], $Roadmap['id']);
            if (!$plan) throw new \Exception('somthing wrong in plan fetching');

            $skills = Skill::getSkills($user['id'], $Roadmap['id']);

            $progress = $plan['completion_percentage'];

            //GET AUTH USER OPPORTUNITY
            $opportunities = Opportunity::getAll();


            $data = [
                "user" => $user,
                "roadmap" => $Roadmap,
                "skills" => $skills,
                "progress" => $progress,
                "opportunities" => $opportunities,
            ];

            echo '<pre>';
            var_dump($data);
            echo '</pre>';
            exit;

            $this->view('dashnoard/dashboadr', $data);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function createPlan()
    {
        // ...
    }

    public function updatePlan()
    {
        // ...
    }

    public function getPlan()
    {
        // ...
    }

    public function getSkills()
    {
        // ...
    }

    public function getProgress()
    {
        // ...
    }
}

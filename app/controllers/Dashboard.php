<?php



namespace app\controllers;

use App\Models\AI;
use App\Core\Controller;
use App\Core\Router;
use App\Models\Answer;
use App\Models\Opportunity;
use App\Models\Roadmap;
use App\Models\Plan;
use App\Models\Questionnaire;
use App\Models\Skill;
use App\Models\User;

use DateTime;

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

            $user = User::getAuthUser();
            if (!$user) $this->view('user/login') ;

            $Roadmap = Roadmap::getRoadmap($user['id']);
            if (!$Roadmap) throw new \Exception('somthing wrong in roadmap fetching');

            $plan = Plan::getLast($user['id'], $Roadmap['id']);
            // if (!$plan) throw new \Exception('somthing wrong in plan fetching');

            $skills = Skill::getAll($user['id'], $Roadmap['id']);

            $progress = $plan['completion_percentage'];



            // GET LAST AUTH USER OPPORTUNITY ---------------------------------
            $LastOpportunity = Opportunity::getLast();

            // CHECK IF THE ARRAY EMPYT  --------------------------------------
            if (!empty($LastOpportunity)) {
                $LastOpportunityDate = new DateTime();
                $Today = new DateTime();
            }

            // CHECK LAST AUTH USER OPPORTUNITY DATE --------------------------
            if (empty($LastOpportunity) || $LastOpportunityDate->format('Y-m-d') < $Today->format('Y-m-d')) {

                // CREATE SKILLS ARRAY ---------------------------------
                $skills_name = [];
                foreach ($skills as $skill) {
                    $skills_name[] = $skill['name'];
                }

                // CREATE QUESTIONS ARRAY ---------------------------------
                $questions_content = [];
                $questions = Questionnaire::getAll();

                if (!empty($questions)) {
                    foreach ($questions as $q) {
                        $questions_content[] = $q['content'];
                    }
                }

                
                // CREATE ANSWERS ARRAY ---------------------------------
                $answers_content = [];
                $answers = Answer::getAll($user['id']);
                
                if (!empty($answers)) {
                    foreach ($answers as $an) {
                        $answers_content[] = $an['content'];
                    }
                }
                

                // GENERATE 3 OPPORTUNITES AND INSERT THEM IN DATABASE ---------------------------------
                    
                $opp = AI::generateOpportunities($skills_name, $Roadmap['content'], $questions_content, $answers_content);
                $data = json_decode($opp ,true) ;

                Opportunity::save($data[0]) ;
                Opportunity::save($data[1]) ;
                Opportunity::save($data[2]) ;
            }

            $opportunities = Opportunity::getAll();


            $data = [
                "user" => $user,
                "roadmap" => $Roadmap,
                "plan" => $plan,
                "skills" => $skills,
                "progress" => $progress,
                "opportunities" => $opportunities,
            ];


            $this->view('dashboard/dashboard', $data);
            
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

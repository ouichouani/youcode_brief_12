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

    public function show()
    {

        try {

            if (!User::isAuthenticated()) $this->view('user/login') ;
            $user = User::getAuthUser();
            $user_id = User::getAuthUser()['id'];

            $Roadmap = Roadmap::getRoadmap($user_id);
            if (!$Roadmap) throw new \Exception('somthing wrong in roadmap fetching');

            $plan = Plan::getLast($user_id, $Roadmap['id']);

            $skills = Skill::getAll($user_id, $Roadmap['id']);

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
                $answers = Answer::getAll($user_id);
                
                if (!empty($answers)) {
                    foreach ($answers as $an) {
                        $answers_content[] = $an['content'];
                    }
                }
                

                // GENERATE 3 OPPORTUNITES AND INSERT THEM IN DATABASE ---------------------------------
                    

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
}

<?php


use App\models\Roadmap;
    class RoadmapController{
        private Roadmap $rdmp;

        public function __construct()
        {
            $this->rdmp = new Roadmap();
        }
        public function renderRoadmap(){
            $userId = $_SESSION['user_id'];
            $roadArr = $this->rdmp->getRoadmap($userId);
            require "../EvolveAI/app/views/roadmap/show.php";
        }
    }
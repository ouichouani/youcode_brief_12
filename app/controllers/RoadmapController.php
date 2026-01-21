<?php

namespace App\controllers;

use App\models\Roadmap;

class RoadmapController
{
    private Roadmap $rdmp;

    public function __construct()
    {
        $this->rdmp = new Roadmap();
    }

    public function renderRoadmap()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? 1;
        $roadmap = $this->rdmp->getRoadmap($userId);
        require "app/views/roadmap/show.php";
    }
}
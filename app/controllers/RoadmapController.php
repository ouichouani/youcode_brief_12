<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Roadmap;

class RoadmapController extends Controller
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

        $this->view('roadmap/show', ['roadmap' => $roadmap]);
    }
}
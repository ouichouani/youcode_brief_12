<?php
namespace App\Controllers;

// namespace App\controllers;

use App\Models\Roadmap;
use App\Core\Controller;
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
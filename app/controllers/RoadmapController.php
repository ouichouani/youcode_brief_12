<?php
namespace App\Controllers;

// namespace App\controllers;

use App\Models\Roadmap;
use App\Core\Controller;
use App\Models\User;

class RoadmapController extends Controller
{
    private Roadmap $rdmp;

    public function __construct()
    {
        $this->rdmp = new Roadmap();
    }

    private function checkAuth()
    {
        if (!User::isAuthenticaded()) {
            header('Location: ' . APP_ROOT . '/login');
            exit;
        }
    }

    public function renderRoadmap()
    {
        $this->checkAuth();
        $userId = $_SESSION['user']['id'];
        $roadmap = $this->rdmp->getRoadmap($userId);

        $this->view('roadmap/show', ['roadmap' => $roadmap]);
    }
}
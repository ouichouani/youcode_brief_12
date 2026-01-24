<?php
namespace App\Controllers;

use App\Models\Roadmap;
use App\Core\Controller;
use App\Models\User;

class RoadmapController extends Controller
{


    public function renderRoadmap()
    {
        $userId = User::getAuthUser()['id'];
        $roadmap = Roadmap::getRoadmap($userId);

        $this->view('roadmap/show', ['roadmap' => $roadmap]);
    }
}
<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Skill;
use App\Models\Task;
use App\Models\Roadmap;

class HomeController extends Controller
{
    public function index()
    {
        if (User::isAuthenticaded()) {
            header('Location: ' . APP_ROOT . '/dashboard');
            exit;
        }
        $this->view('home/splash');
    }

    public function community()
    {
        $this->view('home/community');
    }

    public function skills()
    {
        if (!User::isAuthenticaded()) {
            header('Location: ' . APP_ROOT . '/login');
            exit;
        }

        $user = User::getAuthUser();
        $roadmap = Roadmap::getRoadmap($user['id']);

        $skillsData = [];
        if ($roadmap) {
            $skillsData = Task::getSkillProgress($user['id']);
        }

        $this->view('skills/skills', ['skills' => $skillsData]);
    }

    public function profile()
    {
        $this->view('profile/profile');
    }
}

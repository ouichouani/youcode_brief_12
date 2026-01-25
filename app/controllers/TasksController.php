<?php

namespace App\controllers;

use App\Core\Controller;
use App\Models\Task;
use App\Models\User;



class TasksController extends Controller
{

    private function checkAuth()
    {
        if (!User::isAuthenticaded()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }

    public function index()
    {
        $this->checkAuth();
        $tasks = Task::getAll($_SESSION['user']['id']);
        header('Content-Type: application/json');
        echo json_encode($tasks);
    }

    public function markAsDone()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkAuth();
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? $_POST['id'] ?? null;

            if ($id) {
                $result = Task::markAsDone($id, $_SESSION['user']['id']);

                // If standard form submission (not AJAX)
                if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_POST)) {
                    header('Location: ' . APP_ROOT . '/dashboard');
                    exit;
                }

                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                exit;
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false]);
    }
}

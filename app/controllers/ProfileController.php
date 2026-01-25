<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class ProfileController extends Controller
{
    private function checkAuth()
    {
        if (!User::isAuthenticaded()) {
            header('Location: ' . APP_ROOT . '/login');
            exit;
        }
    }

    public function index()
    {
        $this->checkAuth();
        $user = User::findById($_SESSION['user']['id']);
        $this->view('profile/profile', ['user' => $user]);
    }

    public function update()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';

            if (!empty($name) && !empty($email)) {
                if (User::updateProfile($_SESSION['user']['id'], $name, $email)) {
                    $_SESSION['user']['name'] = $name;
                    $_SESSION['user']['email'] = $email;
                    $_SESSION['success'] = "Profil mis à jour avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la mise à jour du profil.";
                }
            }
        }
        header('Location: ' . APP_ROOT . '/profile');
    }

    public function changePassword()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';

            $user = User::findById($_SESSION['user']['id']);
            if (User::validatePassword($currentPassword, $user['password_hash'])) {
                User::updatePassword($_SESSION['user']['id'], $newPassword);
                $_SESSION['success'] = "Mot de passe modifié avec succès.";
            } else {
                $_SESSION['error'] = "L'ancien mot de passe est incorrect.";
            }
        }
        header('Location: ' . APP_ROOT . '/profile');
    }
}

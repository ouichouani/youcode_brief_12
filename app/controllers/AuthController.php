<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{

    public function showRegister()
    {
        $this->view('user/register');
    }


    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit;
        }

        $fullname = htmlspecialchars(trim($_POST['fullname'] ?? ''));
        $email = htmlspecialchars(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        $errors = $this->validateRegistration($fullname, $email, $password, $confirm_password);

        if (!empty($errors)) {
            $this->storeValidationErrors($errors, ['fullname' => $fullname, 'email' => $email]);
            header('Location: /register');
            exit;
        }

        if ($this->processRegistration($fullname, $email, $password)) {
            $user = User::findByEmail($email);
            if ($user) {
                $this->startUserSession($user);
                $this->storeSuccessMessage("Registration successful! Please complete the questionnaire.");
                header('Location: /questionnaire');
                exit;
            }
            // Fallback if user lookup fails (unlikely)
            header('Location: /login');
            exit;
        } else {
            $this->storeErrorMessage("Registration failed. Please try again.");
            header('Location: /register');
            exit;
        }
    }

    private function validateRegistration(string $fullname, string $email, string $password, string $confirm_password): array
    {
        $errors = [];

        if (empty($fullname) || strlen($fullname) < 2) {
            $errors[] = "Full name must be at least 2 characters";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Password must contain at least one number";
        }
        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match";
        }

        if (User::emailExists($email)) {
            $errors[] = "Email already registered";
        }

        return $errors;
    }

    private function processRegistration(string $fullname, string $email, string $password): bool
    {
        $hashed_password = User::hashPassword($password);

        return User::create(['fullname' => $fullname, 'email' => $email, 'password' => $hashed_password]);
    }

    public function showLogin()
    {
        $this->view('user/login');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        $email = htmlspecialchars(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->storeErrorMessage("Email and password are required");
            header('Location: /login');
            exit;
        }
        $user = User::findByEmail($email);
        if ($user && User::validatePassword($password, $user['password'])) {
            $this->startUserSession($user);
            header('Location: /dashboard');
            exit;
        } else {
            $this->storeErrorMessage("Invalid email or password");
            header('Location: /login');
            exit;
        }
    }

    private function startUserSession(array $user): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_fullname'] = $user['fullname'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['logged_in'] = true;
    }

    private function storeValidationErrors(array $errors, array $oldData = []): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $_SESSION['errors'] = $errors;
        if (!empty($oldData)) {
            $_SESSION['old'] = $oldData;
        }
    }

    private function storeErrorMessage(string $message): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $_SESSION['errors'] = [$message];
    }

    private function storeSuccessMessage(string $message): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $_SESSION['success'] = $message;
    }


    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function showForgotPassword()
    {
        $this->view('user/forgot-password');
    }

    public function forgotPassword()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $_SESSION['success'] = "Password reset instructions have been sent to your email.";
        header('Location: /login');
        exit;
    }
}
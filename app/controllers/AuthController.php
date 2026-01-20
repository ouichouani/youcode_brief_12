<?php

namespace App\controllers;

use App\core\controller;
use App\models\User;

class AuthController extends Controller{
    private $db;
    
    public function __construct(){
        // parent::__construct();
        $this->db = Database::getInstance()->getConnection();
    }

    public function showRegister(){
        $this->view('user/register');
    }

    public function register(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit;
        }

        $fullname = htmlspecialchars($_POST['fullname']);
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

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
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Email already registered";
        }

        if (!empty($errors)) {
            session_start();
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['fullname' => $fullname, 'email' => $email];
            header('Location: /register');
            exit;
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$fullname, $email, $hashed_password])) {
            session_start();
            $_SESSION['success'] = "Registration successful! Please login.";
            header('Location: /login');
            exit;
        } else {
            session_start();
            $_SESSION['errors'] = ["Registration failed. Please try again."];
            header('Location: /register');
            exit;
        }
    }

    public function showLogin(){
        $this->view('user/login');
    }

    public function login(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        $errors = [];

        if (empty($email) || empty($password)) {
            $errors[] = "Email and password are required";
        }

        if (!empty($errors)) {
            session_start();
            $_SESSION['errors'] = $errors;
            header('Location: /login');
            exit;
        }

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_fullname'] = $user['fullname'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            
            header('Location: /dashboard');
            exit;
        } else {
            session_start();
            $_SESSION['errors'] = ["Invalid email or password"];
            header('Location: /login');
            exit;
        }
    }

    public function logout(){
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function showForgotPassword(){
        $this->view('user/forgot-password');
    }

    public function forgotPassword(){
        session_start();
        $_SESSION['success'] = "Password reset instructions have been sent to your email.";
        header('Location: /login');
        exit;
    }
}
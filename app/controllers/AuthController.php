<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller{
    
    public function showRegister(){
        $this->view('user/register');
    }

    public function register(){
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
            $this->storeSuccessMessage("Registration successful! Please login.");
            header('Location: /login');
            exit;
        } else {
            $this->storeErrorMessage("Registration failed. Please try again.");
            header('Location: /register');
            exit;
        }
    }

    private function validateRegistration(string $fullname, string $email, string $password, string $confirm_password): array {
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

    private function processRegistration(string $fullname, string $email, string $password): bool {
        $hashed_password = User::hashPassword($password);
        
        return User::create(['fullname' => $fullname,'email' => $email,'password' => $hashed_password]);
    }

    public function showLogin(){
        $this->view('user/login');
    }

    public function login(){
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
        if ($user && User::validatePassword($password, $user['password_hash'])) {
            $this->startUserSession($user);
            header('Location: /dashboard');
            exit;
        } else {
            $this->storeErrorMessage("Invalid email or password");
            header('Location: /login');
            exit;
        }
    }

    private function startUserSession(array $user): void {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_fullname'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['logged_in'] = true;
    }

    private function storeValidationErrors(array $errors, array $oldData = []): void {
        session_start();
        $_SESSION['errors'] = $errors;
        if (!empty($oldData)) {
            $_SESSION['old'] = $oldData;
        }
    }

     private function storeErrorMessage(string $message): void {
        session_start();
        $_SESSION['errors'] = [$message];
    }

    private function storeSuccessMessage(string $message): void {
        session_start();
        $_SESSION['success'] = $message;
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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /forgot-password');
            exit;
        }

        $email = htmlspecialchars(trim($_POST['email'] ?? ''));
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->storeErrorMessage("Please provide a valid email address");
            header('Location: /forgot-password');
            exit;
        }
        
        if (!User::emailExists($email)) {
            $this->storeErrorMessage("No account found with this email address");
            header('Location: /forgot-password');
            exit;
        }

        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        if (User::createPasswordResetToken($email, $token, $expiresAt)) {
            $this->sendPasswordResetEmail($email, $token);
            
            $this->storeSuccessMessage("Password reset instructions have been sent to your email.");
            header('Location: /login');
            exit;
        } else {
            $this->storeErrorMessage("Failed to process your request. Please try again.");
            header('Location: /forgot-password');
            exit;
        }
    }

    public function showResetPassword($token = null) {
        if (!$token) {
            header('Location: /forgot-password');
            exit;
        }

        $user = User::findValidToken($token);
        
        if (!$user) {
            $this->storeErrorMessage("Invalid or expired reset token");
            header('Location: /forgot-password');
            exit;
        }

        $this->view('user/reset-password', ['token' => $token]);
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /forgot-password');
            exit;
        }
        
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        if (empty($token)) {
            $this->storeErrorMessage("Invalid reset token");
            header('Location: /forgot-password');
            exit;
        }

        $errors = [];
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
        
        if (!empty($errors)) {
            $this->storeValidationErrors($errors);
            header('Location: /reset-password/' . $token);
            exit;
        }

        if (User::resetPasswordWithToken($token, $password)) {
            $this->storeSuccessMessage("Password has been reset successfully. Please login.");
            header('Location: /login');
            exit;
        } else {
            $this->storeErrorMessage("Invalid or expired reset token");
            header('Location: /forgot-password');
            exit;
        }
    }
    private function sendPasswordResetEmail(string $email, string $token): bool {
        try {
            $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/reset-password/" . $token;
            $subject = "Password Reset Request - AI Revenue Generator";
            $body = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
                    .button { display: inline-block; background: #667eea; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 20px 0; }
                    .code-box { background: #f0f0f0; padding: 15px; border-radius: 5px; font-family: monospace; word-break: break-all; margin: 15px 0; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='content'>
                        <h2>Hello,</h2>
                        <p>We received a request to reset your password for your AI Revenue Generator account.</p>
                        
                        <p><strong>Click the button below to reset your password:</strong></p>
                        
                        <div style='text-align: center;'>
                            <a href='{$resetLink}' class='button'>Reset Password</a>
                        </div>
                        
                        <p>Or copy and paste this link into your browser:</p>
                        <div class='code-box'>{$resetLink}</div>
                        
                        <p><strong>This link will expire in 1 hour.</strong></p>
                        
                        <p>If you didn't request a password reset, please ignore this email or contact support if you have concerns.</p>
                    </div>
                </div>
            </body>
            </html>";
            $textBody = "Password Reset Request\n\n";
            $textBody .= "Hello,\n\n";
            $textBody .= "We received a request to reset your password for your AI Revenue Generator account.\n\n";
            $textBody .= "Click the link below to reset your password:\n";
            $textBody .= $resetLink . "\n\n";
            $textBody .= "This link will expire in 1 hour.\n\n";
            $textBody .= "If you didn't request a password reset, please ignore this email.\n\n";
            $textBody .= "Best regards,\n";
            $textBody .= "The AI Revenue Generator Team";

            $mailer = new \App\core\Mailer();
            return $mailer->send($email, $subject, $body);
        } catch (Exception $e) {
            error_log("Failed to send password reset email: " . $e->getMessage());
            return false;
        }
    }
}
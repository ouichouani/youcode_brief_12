<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Core\Mailer;
use Exception;

class AuthController extends Controller
{

    public function showRegister()
    {
        if (User::isAuthenticaded()) {
            header('Location: ' . APP_ROOT . '/dashboard');
            exit;
        }
        $this->view('user/register');
    }


    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // header('Location: /register');
            $this->view("user/register");
            exit;
        }

        $fullname = htmlspecialchars(trim($_POST['fullname'] ?? ''));
        $email = htmlspecialchars(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        $errors = $this->validateRegistration($fullname, $email, $password, $confirm_password);

        if (!empty($errors)) {
            $this->storeValidationErrors($errors, ['fullname' => $fullname, 'email' => $email]);
            // header('Location: /register');
            $this->view("user/register");

            exit;
        }

        if ($this->processRegistration($fullname, $email, $password)) {
            $user = User::findByEmail($email);
            if ($user) {
                $this->startUserSession($user);
                // echo APP_ROOT ;
                // exit ;
                $this->storeSuccessMessage("Registration successful! Please complete the questionnaire.");
                header('Location: ' . APP_ROOT . '/questionnaire');
                exit;
            }
            // Fallback if user lookup fails (unlikely)
            //                         $this->view("user/login") ;

            $this->view("user/login");

            exit;
        } else {
            $this->storeErrorMessage("Registration failed. Please try again.");
            // header('Location: /register');
            $this->view("user/register");

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
        if (User::isAuthenticaded()) {
            header('Location: ' . APP_ROOT . '/dashboard');
            exit;
        }
        $this->view('user/login');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view("user/login");

            // $this->view("user/login");

            exit;
        }

        $email = htmlspecialchars(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->storeErrorMessage("Email and password are required");
            $this->view("user/login");

            exit;
        }
        $user = User::findByEmail($email);
        if ($user && User::validatePassword($password, $user['password_hash'])) {
            $this->startUserSession($user);
            header('Location: ' . APP_ROOT . '/dashboard');
            exit;
        } else {
            $this->storeErrorMessage("Invalid email or password");
            $this->view("user/login");

            exit;
        }
    }

    private function startUserSession(array $user): void
    {
        // session_start();
        $_SESSION['user'] = $user;
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
        header('Location: ' . APP_ROOT . '/login');
        exit;
    }

    public function showForgotPassword()
    {
        $this->view('user/forgot-password');
    }

    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '. APP_ROOT .'/forgot-password');
            exit;
        }

        $email = htmlspecialchars(trim($_POST['email'] ?? ''));

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->storeErrorMessage("Please provide a valid email address");
            header('Location: '. APP_ROOT .'/forgot-password');
            exit;
        }

        if (!User::emailExists($email)) {
            $this->storeErrorMessage("No account found with this email address");
            header('Location: '. APP_ROOT .'/forgot-password');
            exit;
        }

        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        if (User::createPasswordResetToken($email, $token, $expiresAt)) {
            $this->sendPasswordResetEmail($email, $token);

            $this->storeSuccessMessage("Password reset instructions have been sent to your email.");
            header('Location: '. APP_ROOT .'/login');
            exit;
        } else {
            $this->storeErrorMessage("Failed to process your request. Please try again.");
            header('Location: '. APP_ROOT .'/forgot-password');
            exit;
        }
    }

    public function showResetPassword()
    {
        $token = $_GET['token'] ?? null;
        if (!$token) {
            header('Location: '. APP_ROOT .'/forgot-password');
            exit;
        }

        $user = User::findValidToken($token);

        if (!$user) {
            $this->storeErrorMessage("Invalid or expired reset token");
            header('Location: '. APP_ROOT .'/forgot-password');
            exit;
        }

        $this->view('user/reset-password', ['token' => $token]);
    }

    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '. APP_ROOT .'/forgot-password');
            exit;
        }

        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($token)) {
            $this->storeErrorMessage("Invalid reset token");
            header('Location: '. APP_ROOT .'/forgot-password');
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
            header('Location: '. APP_ROOT .'/reset-password?token=' . $token);
            exit;
        }

        if (User::resetPasswordWithToken($token, $password)) {
            $this->storeSuccessMessage("Password has been reset successfully. Please login.");
            header('Location: '. APP_ROOT .'/login');
            exit;
        } else {
            $this->storeErrorMessage("Invalid or expired reset token");
            header('Location: '. APP_ROOT .'/forgot-password');
            exit;
        }
    }

    private function sendPasswordResetEmail(string $email, string $token): bool
    {
        try {
            $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/youcode_brief_12/reset-password?token=" . $token;
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

            $mailer = new Mailer();
            return $mailer->send($email, $subject, $body);
        } catch (Exception $e) {
            error_log("Failed to send password reset email: " . $e->getMessage());
            return false;
        }
    }


}
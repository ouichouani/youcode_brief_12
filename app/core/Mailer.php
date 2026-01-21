<?php

namespace App\core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class Mailer {
    private PHPMailer $mailer;
    private array $config;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $this->config = [
            'host' => $_ENV['SMTP_HOST'],
            'username' => $_ENV['SMTP_USERNAME'],
            'password' => $_ENV['SMTP_PASSWORD'],
            'port' => $_ENV['SMTP_PORT'],
            'from_email' =>$_ENV['SMTP_USERNAME'],
            'from_name' =>'AI Revenue Generator'
        ];

        $this->mailer = new PHPMailer(true);
        $this->configure();
    }

    private function configure(): void {
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['host'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->config['username'];
        $this->mailer->Password = $this->config['password'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = $this->config['port'];
        $this->mailer->CharSet = 'UTF-8';

        $this->mailer->setFrom($this->config['from_email'], $this->config['from_name']);
        $this->mailer->isHTML(true);
    }

    public function send(string $to, string $subject, string $body): bool {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            
            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Email error: " . $this->mailer->ErrorInfo);
            return false;
        }
    }

    public static function sendStatic(string $to, string $subject, string $body): bool {
        $mailer = new self();
        return $mailer->send($to, $subject, $body);
    }
}
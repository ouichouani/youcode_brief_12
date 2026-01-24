<?php
namespace App\Models;

use App\Core\Database;

class User
{

    public static function create(array $data): bool
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
        return $stmt->execute([$data['fullname'], $data['email'], $data['password']]);
    }

    public static function findByEmail(string $email): ?array
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public static function emailExists(string $email): bool
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public static function findById(int $id): ?array
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public static function validatePassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function updatePassword(int $userId, string $newPassword): bool
    {
        $connection = Database::getInstance()->getConnection();
        $hashedPassword = self::hashPassword($newPassword);
        $stmt = $connection->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $userId]);
    }

    public static function updateProfile(int $userId, string $name, string $email): bool
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $userId]);
    }

    public static function createPasswordResetToken(string $email, string $token, string $expiresAt): bool
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("UPDATE users SET reset_token = ?, reset_token_expires_at = ? WHERE email = ?");
        return $stmt->execute([$token, $expiresAt, $email]);
    }

    public static function findValidToken(string $token): ?array
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expires_at > NOW()");
        $stmt->execute([$token]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public static function deleteToken(string $token): bool
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("UPDATE users SET reset_token = NULL, reset_token_expires_at = NULL WHERE reset_token = ?");
        return $stmt->execute([$token]);
    }

    public static function getAuthUser(): array
    {
        if (!self::isAuthenticaded())
            return [];
        return $_SESSION["user"];
    }

    public static function isAuthenticaded(): bool
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['id'])
            return true;
        return false;
    }

    public static function resetPasswordWithToken(string $token, string $newPassword): bool
    {
        $connection = Database::getInstance()->getConnection();
        $hashedPassword = self::hashPassword($newPassword);
        $stmt = $connection->prepare("UPDATE users SET password_hash = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE reset_token = ? AND reset_token_expires_at > NOW()");
        $stmt->execute([$hashedPassword, $token]);
        return $stmt->rowCount() === 1;
    }
}
?>
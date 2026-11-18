<?php
namespace App\Config;
use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $dsn = "pgsql:host=" . $_ENV['DB_HOST']
                 . ";port=" . $_ENV['DB_PORT']
                 . ";dbname=" . $_ENV['DB_NAME'];
            try {
                self::$connection = new PDO(
                    $dsn,
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASSWORD'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                exit;
            }
        }
        return self::$connection;
    }
}
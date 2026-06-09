<?php

declare(strict_types=1);

class Database
{
    private static ?mysqli $conn = null;

    public static function connect(): mysqli
    {
        if (self::$conn === null) {

            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: '';
            $name = getenv('DB_NAME') ?: 'studyspace';
            $port = getenv('DB_PORT') ? (int)getenv('DB_PORT') : 3307;

            self::$conn = new mysqli(
                $host,
                $user,
                $pass,
                $name,
                (int)$port
            );

            if (self::$conn->connect_error) {
                die("Error de conexión: " . self::$conn->connect_error);
            }

            self::$conn->set_charset("utf8mb4");
        }

        return self::$conn;
    }
}
<?php

declare(strict_types=1);

class Database
{
    private static ?mysqli $conn = null;

    public static function connect(): mysqli
    {
        if (self::$conn === null) {

            $host = getenv('MYSQLHOST') ?: '127.0.0.1';
            $user = getenv('MYSQLUSER') ?: 'root';
            $pass = getenv('MYSQLPASSWORD') ?: '';
            $name = getenv('MYSQLDATABASE') ?: 'studyspace';
            $port = getenv('MYSQLPORT') ? (int)getenv('MYSQLPORT') : 3306;

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
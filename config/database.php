<?php

declare(strict_types=1);

class Database {

    private const HOST = "127.0.0.1";
    private const USER = "root";
    private const PASSWORD = "";
    private const DBNAME = "studyspace";
    private const PORT = 3307;

    private static ?mysqli $conn = null;

    public static function connect(): mysqli {

        if (self::$conn === null) {

            self::$conn = new mysqli(
                self::HOST,
                self::USER,
                self::PASSWORD,
                self::DBNAME,
                self::PORT
            );

            if (self::$conn->connect_error) {

                die(
                    "Error de conexión: " .
                    self::$conn->connect_error
                );
            }

            self::$conn->set_charset("utf8mb4");
        }

        return self::$conn;
    }
}
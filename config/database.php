<?php
class Database {

    private static ?mysqli $conn = null;

    public static function connect(): mysqli {

        if (!self::$conn) {

            // Puerto 3307 usado en entorno local XAMPP
            self::$conn = new mysqli(
                "127.0.0.1",
                "root",
                "",
                "studyspace",
                3307
            );

            if (self::$conn->connect_error) {
                die("Error DB: " . self::$conn->connect_error);
            }

            self::$conn->set_charset("utf8mb4");
        }

        return self::$conn;
    }
}
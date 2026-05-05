<?php
class Database {

    private static $conn;

    public static function connect() {

        if (!self::$conn) {

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
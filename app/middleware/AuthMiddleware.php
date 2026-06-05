<?php

declare(strict_types=1);

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!isset($_SESSION['id'])) {

            header(
                "Location: /studyspace/public/login"
            );

            exit;
        }
    }
}
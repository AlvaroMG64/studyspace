<?php

declare(strict_types=1);

require_once "../core/helpers.php";

class AuthMiddleware
{
    public static function handle(): void
    {
        // Usuario no autenticado
        if (!isset($_SESSION['id'])) {

            header("Location: " . base_url('login'));
            exit;
        }
    }
}
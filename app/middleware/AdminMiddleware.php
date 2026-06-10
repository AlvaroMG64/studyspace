<?php

declare(strict_types=1);

require_once BASE_PATH . "/core/helpers.php";

class AdminMiddleware
{
    public static function handle(): void
    {
        // No hay sesión o no es admin
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {

            http_response_code(403);

            header("Location: " . base_url(''));

            exit;
        }
    }
}
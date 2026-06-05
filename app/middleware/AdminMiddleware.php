<?php

declare(strict_types=1);

class AdminMiddleware
{
    public static function handle(): void
    {
        if (
            !isset($_SESSION['rol'])
            || $_SESSION['rol'] !== 'admin'
        ) {

            http_response_code(403);

            die("Acceso denegado");
        }
    }
}
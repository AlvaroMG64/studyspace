<?php

declare(strict_types=1);

/**
 * Muestra mensajes de error y éxito en sesión
 */
function mensaje(): void
{
    if (isset($_SESSION['error'])) {

        echo '
        <div class="
            bg-red-100
            border
            border-red-400
            text-red-700
            px-4
            py-3
            rounded-xl
            mb-4
        ">
            ' . htmlspecialchars($_SESSION['error']) . '
        </div>
        ';

        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {

        echo '
        <div class="
            bg-green-100
            border
            border-green-400
            text-green-700
            px-4
            py-3
            rounded-xl
            mb-4
        ">
            ' . htmlspecialchars($_SESSION['success']) . '
        </div>
        ';

        unset($_SESSION['success']);
    }
}

/**
 * Comprueba si el usuario es administrador
 */
function esAdmin(): bool
{
    return isset($_SESSION['rol'])
        && $_SESSION['rol'] === 'admin';
}

/**
 * URL base dinámica
 * Compatible con localhost y Render
 */
function base_url(string $path = ''): string
{
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

    $basePath = rtrim(
        str_replace('\\', '/', dirname($scriptName)),
        '/'
    );

    if ($basePath === '/') {
        $basePath = '';
    }

    return $basePath . '/' . ltrim($path, '/');
}

function csrf_token(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}
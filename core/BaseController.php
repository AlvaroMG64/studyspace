<?php

declare(strict_types=1);

class BaseController
{
    protected function requireAuth(): void
    {
        $this->checkSessionTimeout();

        if (!isset($_SESSION['id'])) {
            header("Location: /login");
            exit;
        }
    }

    protected function requireAuthApi(): void
    {
        $this->checkSessionTimeout();

        if (!isset($_SESSION['id'])) {
            http_response_code(401);
            echo json_encode([
                "success" => false,
                "message" => "No autenticado"
            ]);
            exit;
        }
    }

    // ✅ NUEVO: ADMIN CHECK (ESTO ES LO QUE TE FALTABA)
    protected function requireAdmin(): void
    {
        $this->checkSessionTimeout();

        if (!isset($_SESSION['id'])) {
            header("Location: /login");
            exit;
        }

        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            http_response_code(403);
            die("Acceso denegado");
        }
    }

    protected function checkSessionTimeout(): void
    {
        $timeout = 1800; // 30 min

        if (!isset($_SESSION['last_activity'])) {
            $_SESSION['last_activity'] = time();
            return;
        }

        if (time() - $_SESSION['last_activity'] > $timeout) {
            session_unset();
            session_destroy();

            if ($this->isApi()) {
                http_response_code(401);
                echo json_encode([
                    "success" => false,
                    "message" => "Sesión expirada"
                ]);
                exit;
            }

            header("Location: /login");
            exit;
        }

        $_SESSION['last_activity'] = time();
    }

    private function isApi(): bool
    {
        return str_starts_with($_SERVER['REQUEST_URI'], '/api');
    }

    protected function view(string $path, array $data = []): void
    {
        extract($data);
        require "../app/views/$path.php";
    }

    protected function json(array|object $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
<?php

declare(strict_types=1);

abstract class BaseController
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        require_once "../app/views/{$view}.php";
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    protected function json(mixed $data): void
    {
        header("Content-Type: application/json");
        echo json_encode($data);
        exit;
    }

    protected function requireAuth(): void
    {
        if (!isset($_SESSION['id'])) {
            $this->redirect("/studyspace/public/login");
        }
    }

    protected function requireAdmin(): void
    {
        $this->requireAuth();

        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            die("Acceso denegado");
        }
    }
}
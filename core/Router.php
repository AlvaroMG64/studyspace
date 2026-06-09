<?php

declare(strict_types=1);

class Router
{
    private array $routes = [];

    public function get(string $uri, string $action): void
    {
        $this->routes['GET'][$this->format($uri)] = $action;
    }

    public function post(string $uri, string $action): void
    {
        $this->routes['POST'][$this->format($uri)] = $action;
    }

    private function format(string $uri): string
    {
        return trim($uri, '/');
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // =========================
        // FIX BASE PATH ROBUSTO
        // =========================
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $baseDir = str_replace('\\', '/', dirname($scriptName));

        if ($baseDir !== '/' && $baseDir !== '.') {
            $uri = str_replace($baseDir, '', $uri);
        }

        $uri = trim($uri, '/');

        $action = $this->routes[$method][$uri] ?? null;

        if ($action === null) {
            http_response_code(404);

            if (str_starts_with($uri, 'api/')) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => false,
                    "message" => "Endpoint no encontrado",
                    "route" => $uri
                ]);
                exit;
            }

            die("404 - Página no encontrada");
        }

        [$controller, $function] = explode('@', $action);

        $controllerPath = __DIR__ . "/../app/controllers/$controller.php";

        if (!file_exists($controllerPath)) {
            http_response_code(500);
            die("Controlador no encontrado");
        }

        require_once $controllerPath;

        if (!class_exists($controller)) {
            http_response_code(500);
            die("Clase controlador inválida");
        }

        $controllerInstance = new $controller();

        if (!method_exists($controllerInstance, $function)) {
            http_response_code(500);
            die("Método no encontrado");
        }

        call_user_func([$controllerInstance, $function]);
    }
}
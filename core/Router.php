<?php

class Router {

    private array $routes = [];

    public function get($uri, $action) {

        $this->routes['GET'][$this->format($uri)] = $action;
    }

    public function post($uri, $action) {

        $this->routes['POST'][$this->format($uri)] = $action;
    }

    private function format($uri): string {

        return trim($uri, '/');
    }

    public function dispatch() {

        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        );

        // Quitar carpeta public
        $uri = str_replace(
            '/studyspace/public',
            '',
            $uri
        );

        $uri = $this->format($uri);

        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {

            http_response_code(404);

            die("404 - Página no encontrada");
        }

        [$controller, $function] = explode('@', $action);

        require_once "../app/controllers/$controller.php";

        $controller = new $controller();

        call_user_func([$controller, $function]);
    }
}
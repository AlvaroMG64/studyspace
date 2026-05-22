<?php

declare(strict_types=1);

class Controller {

    protected function view(
        string $view,
        array $data = []
    ): void {

        extract($data);

        require_once __DIR__ .
            "/../app/views/$view.php";
    }

    protected function redirect(
        string $url
    ): void {

        header("Location: $url");

        exit;
    }
}
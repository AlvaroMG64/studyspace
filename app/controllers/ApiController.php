<?php

declare(strict_types=1);

require_once BASE_PATH . "/core/BaseController.php";
require_once BASE_PATH . "/app/services/DashboardService.php";
require_once BASE_PATH . "/app/models/Biblioteca.php";

class ApiController extends BaseController
{
    private DashboardService $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function stats(): void
    {
        $this->requireAuth();

        $stats = $this->dashboardService->obtenerStats();
        $this->json($stats);
    }

    public function bibliotecasTree(): void
    {
        $this->requireAuth();

        $bibliotecaModel = new Biblioteca();
        $tree = $bibliotecaModel->obtenerTree();

        $this->json($tree);
    }
}
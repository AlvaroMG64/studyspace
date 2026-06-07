<?php

declare(strict_types=1);

require_once "../core/BaseController.php";

require_once "../app/services/DashboardService.php";
require_once "../app/models/Biblioteca.php";

class ApiController extends BaseController
{
    private DashboardService $dashboardService;

    public function __construct()
    {
        $this->requireAuth();

        $this->dashboardService =
            new DashboardService();
    }

    // =========================
    // STATS DASHBOARD
    // =========================

    public function stats(): void
    {
        $stats =
            $this->dashboardService
                ->obtenerStats();

        $this->json($stats);
    }

    // =========================
    // ÁRBOL BIBLIOTECAS
    // =========================

    public function bibliotecasTree(): void
    {
        $bibliotecaModel =
            new Biblioteca();

        $tree =
            $bibliotecaModel
                ->obtenerTree();

        $this->json($tree);
    }
}
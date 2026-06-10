<?php

declare(strict_types=1);

require_once BASE_PATH . "/core/BaseController.php";
require_once BASE_PATH . "/app/services/DashboardService.php";

class AdminController extends BaseController
{
    private DashboardService $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function dashboard(): void
    {
        $this->requireAdmin();

        $reservas = $this->dashboardService->obtenerReservas();

        $this->view("dashboard/admin", [
            "reservas" => $reservas
        ]);
    }
}
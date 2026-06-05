<?php

declare(strict_types=1);

require_once "../core/BaseController.php";

require_once "../app/services/DashboardService.php";

class AdminController extends BaseController {

    private DashboardService $dashboardService;

    public function __construct()
    {
        $this->requireAdmin();

        $this->dashboardService =
            new DashboardService();
    }

    public function dashboard(): void
    {
        $reservas =
            $this->dashboardService
                ->obtenerReservas();

        $this->view(
            "dashboard/admin",
            [
                "reservas" => $reservas
            ]
        );
    }
}
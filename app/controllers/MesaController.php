<?php

declare(strict_types=1);

require_once "../core/BaseController.php";

require_once "../app/services/MesaService.php";

class MesaController extends BaseController
{
    private MesaService $mesaService;

    public function __construct()
    {
        $this->requireAuth();

        $this->mesaService =
            new MesaService();
    }

    // =========================
    // OBTENER MESAS
    // =========================

    public function obtenerPorSala(): void
    {
        $sala =
            intval(
                $_GET['sala'] ?? 0
            );

        $mesas =
            $this->mesaService
                ->obtenerMesas(
                    $sala
                );

        $this->json($mesas);
    }
}
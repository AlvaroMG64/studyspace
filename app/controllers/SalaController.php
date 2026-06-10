<?php

declare(strict_types=1);

require_once BASE_PATH . "/core/BaseController.php";
require_once BASE_PATH . "/app/services/SalaService.php";

class SalaController extends BaseController
{
    private SalaService $salaService;

    public function __construct()
    {
        $this->salaService = new SalaService();
    }

    public function obtenerPorBiblioteca(): void
    {
        $this->requireAuthApi();

        $biblioteca =
            intval($_GET['biblioteca'] ?? 0);

        $salas =
            $this->salaService
                ->obtenerSalas($biblioteca);

        $this->json($salas);
    }
}
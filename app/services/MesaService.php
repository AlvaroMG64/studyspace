<?php

declare(strict_types=1);

require_once "../app/models/Mesa.php";

class MesaService {

    private Mesa $mesaModel;

    public function __construct()
    {
        $this->mesaModel =
            new Mesa();
    }

    // =========================
    // MESAS
    // =========================

    public function obtenerMesas(
        int $sala
    ): array {

        return $this->mesaModel
            ->obtenerPorSala(
                $sala
            );
    }
}
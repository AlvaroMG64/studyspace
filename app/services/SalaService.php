<?php

declare(strict_types=1);

require_once "../app/models/Sala.php";

class SalaService {

    private Sala $salaModel;

    public function __construct()
    {
        $this->salaModel =
            new Sala();
    }

    // =========================
    // SALAS
    // =========================

    public function obtenerSalas(
        int $biblioteca
    ): array {

        return $this->salaModel
            ->obtenerPorBiblioteca(
                $biblioteca
            );
    }
}
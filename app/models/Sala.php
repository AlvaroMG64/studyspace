<?php

declare(strict_types=1);

require_once "../core/Model.php";

class Sala extends Model
{
    // =========================
    // OBTENER POR BIBLIOTECA
    // =========================

    public function obtenerPorBiblioteca(
        int $biblioteca
    ): array {

        $stmt =
            $this->db->prepare("
                SELECT *
                FROM salas
                WHERE id_biblioteca = ?
                ORDER BY nombre_s ASC
            ");

        $stmt->bind_param(
            "i",
            $biblioteca
        );

        $stmt->execute();

        $result =
            $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
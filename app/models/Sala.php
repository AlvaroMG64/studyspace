<?php

declare(strict_types=1);

require_once BASE_PATH . "/core/Model.php";

class Sala extends Model
{
    public function obtenerPorBiblioteca(int $biblioteca): array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM salas
            WHERE id_biblioteca = ?
            ORDER BY nombre_s ASC
        ");

        $stmt->bind_param("i", $biblioteca);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
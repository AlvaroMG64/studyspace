<?php

declare(strict_types=1);

require_once BASE_PATH . "/core/Model.php";

class Biblioteca extends Model
{
    public function obtenerTodas(): array
    {
        $sql = "
            SELECT *
            FROM bibliotecas
            ORDER BY nombre_b ASC
        ";

        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerTree(): array
    {
        $sql = "
            SELECT
                b.id_biblioteca,
                b.nombre_b,

                s.id_sala,
                s.nombre_s,

                m.id_mesa,
                m.numero

            FROM bibliotecas b
            LEFT JOIN salas s ON s.id_biblioteca = b.id_biblioteca
            LEFT JOIN mesas m ON m.id_sala = s.id_sala

            ORDER BY b.nombre_b, s.nombre_s, m.numero
        ";

        $result = $this->db->query($sql);

        $tree = [];

        while ($row = $result->fetch_assoc()) {

            $bibId = $row['id_biblioteca'];
            $salaId = $row['id_sala'] ?? null;

            if (!isset($tree[$bibId])) {
                $tree[$bibId] = [
                    "id" => $bibId,
                    "nombre" => $row['nombre_b'],
                    "salas" => []
                ];
            }

            if ($salaId !== null && !isset($tree[$bibId]['salas'][$salaId])) {
                $tree[$bibId]['salas'][$salaId] = [
                    "id" => $salaId,
                    "nombre" => $row['nombre_s'],
                    "mesas" => []
                ];
            }

            if (!empty($row['id_mesa']) && $salaId !== null) {
                $tree[$bibId]['salas'][$salaId]['mesas'][] = [
                    "id" => $row['id_mesa'],
                    "numero" => $row['numero']
                ];
            }
        }

        return array_map(function ($b) {
            $b['salas'] = array_values($b['salas']);
            return $b;
        }, array_values($tree));
    }
}
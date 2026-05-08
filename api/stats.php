<?php
require_once "../config/database.php";

header("Content-Type: application/json");

$conn = Database::connect();

// TOTAL RESERVAS
$totalReservas = $conn->query("
SELECT COUNT(*) total
FROM reservas
")->fetch_assoc()['total'];

// TOTAL USUARIOS
$totalUsuarios = $conn->query("
SELECT COUNT(*) total
FROM usuarios
")->fetch_assoc()['total'];

// TOTAL MESAS
$totalMesas = $conn->query("
SELECT COUNT(*) total
FROM mesas
")->fetch_assoc()['total'];

// RESERVAS HOY
$hoy = date("Y-m-d");

$stmt = $conn->prepare("
SELECT COUNT(*) total
FROM reservas
WHERE fecha_r = ?
");

$stmt->bind_param("s", $hoy);
$stmt->execute();

$reservasHoy = $stmt->get_result()->fetch_assoc()['total'];

// RESERVAS POR DÍA (gráfica)
$grafica = [];

$result = $conn->query("
SELECT fecha_r, COUNT(*) total
FROM reservas
GROUP BY fecha_r
ORDER BY fecha_r ASC
LIMIT 7
");

while ($row = $result->fetch_assoc()) {
    $grafica[] = $row;
}

echo json_encode([
    "totalReservas" => $totalReservas,
    "totalUsuarios" => $totalUsuarios,
    "totalMesas" => $totalMesas,
    "reservasHoy" => $reservasHoy,
    "grafica" => $grafica
]);
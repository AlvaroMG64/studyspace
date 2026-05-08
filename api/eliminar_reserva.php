<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth.php";

header("Content-Type: application/json");

$conn = Database::connect();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido"
    ]);
    exit;
}

$id = intval($_POST['id'] ?? 0);
$usuario = $_SESSION['id'] ?? 0;

// Obtener reserva
$stmt = $conn->prepare("
SELECT id_usuario
FROM reservas
WHERE id_reserva = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$reserva = $stmt->get_result()->fetch_assoc();

if (!$reserva) {

    echo json_encode([
        "success" => false,
        "message" => "Reserva no encontrada"
    ]);
    exit;
}

// Seguridad
if ($reserva['id_usuario'] != $usuario && !esAdmin()) {

    echo json_encode([
        "success" => false,
        "message" => "No autorizado"
    ]);
    exit;
}

// Eliminar
$stmt = $conn->prepare("
DELETE FROM reservas
WHERE id_reserva = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode([
    "success" => true,
    "message" => "Reserva eliminada correctamente"
]);
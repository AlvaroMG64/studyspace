<?php
require_once "../includes/auth.php";
require_once "../config/database.php";

$conn = Database::connect();

if (!isset($_GET['id'])) {
    header("Location: mis_reservas.php");
    exit;
}

$id = intval($_GET['id']);
$usuario = $_SESSION['id'];

// Obtener reserva
$stmt = $conn->prepare("SELECT id_usuario FROM reservas WHERE id_reserva = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$reserva = $stmt->get_result()->fetch_assoc();

if (!$reserva) {
    die("Reserva no encontrada");
}

if ($reserva['id_usuario'] != $usuario && !esAdmin()) {
    die("No autorizado");
}

// Eliminar
$stmt = $conn->prepare("DELETE FROM reservas WHERE id_reserva = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$_SESSION['success'] = "Reserva eliminada correctamente";
header("Location: mis_reservas.php");
exit;
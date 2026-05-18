<?php
require_once "../includes/auth.php";
require_once "../config/database.php";

$conn = Database::connect();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: mis_reservas.php");
    exit;
}

$id = intval($_POST['id']);
$fecha = $_POST['fecha'];
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$mesa = intval($_POST['mesa']);
$usuario = $_SESSION['id'];

if (!$fecha || !$inicio || !$fin || !$mesa) {
    $_SESSION['error'] = "Datos incompletos";
    header("Location: editar.php?id=$id");
    exit;
}

if ($inicio >= $fin) {
    $_SESSION['error'] = "Hora incorrecta";
    header("Location: editar.php?id=$id");
    exit;
}

if ($fecha < date("Y-m-d")) {
    $_SESSION['error'] = "No puedes reservar en el pasado";
    header("Location: editar.php?id=$id");
    exit;
}

// OBTENER RESERVA
$stmt = $conn->prepare("
SELECT *
FROM reservas
WHERE id_reserva = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$reserva = $stmt->get_result()->fetch_assoc();

if (!$reserva) {
    die("Reserva no encontrada");
}

if ($reserva['id_usuario'] != $usuario && !esAdmin()) {
    die("No autorizado");
}

// VALIDAR SOLAPAMIENTO DE MESA
$stmt = $conn->prepare("
SELECT id_reserva
FROM reservas
WHERE id_mesa = ?
AND fecha_r = ?
AND id_reserva != ?
AND NOT (hora_fin <= ? OR hora_inicio >= ?)
");

$stmt->bind_param(
    "isiss",
    $mesa,
    $fecha,
    $id,
    $inicio,
    $fin
);

$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {

    $_SESSION['error'] = "La mesa ya está ocupada";
    header("Location: editar.php?id=$id");
    exit;
}

// VALIDAR SOLAPAMIENTO DE USUARIO
$stmt = $conn->prepare("
SELECT id_reserva
FROM reservas
WHERE id_usuario = ?
AND fecha_r = ?
AND id_reserva != ?
AND NOT (hora_fin <= ? OR hora_inicio >= ?)
");

$stmt->bind_param(
    "isis",
    $usuario,
    $fecha,
    $id,
    $inicio,
    $fin
);

$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {

    $_SESSION['error'] = "Ya tienes otra reserva en ese horario";
    header("Location: editar.php?id=$id");
    exit;
}

// ACTUALIZAR
$stmt = $conn->prepare("
UPDATE reservas
SET fecha_r = ?,
hora_inicio = ?,
hora_fin = ?,
id_mesa = ?
WHERE id_reserva = ?
");

$stmt->bind_param(
    "sssii",
    $fecha,
    $inicio,
    $fin,
    $mesa,
    $id
);

$stmt->execute();

$_SESSION['success'] = "Reserva actualizada correctamente";

header("Location: mis_reservas.php");
exit;
<?php
session_start();
require_once "../config/database.php";

$conn = Database::connect();

$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$password = trim($_POST['password']);

if (!$email || !$password) {
    $_SESSION['error'] = "Todos los campos son obligatorios";
    header("Location: login.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Email no válido";
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    if (password_verify($password, $usuario['contrasena'])) {

        $_SESSION['id'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre_u'];
        $_SESSION['rol'] = $usuario['rol'];

        header("Location: ../index.php");
        exit;
    }
}

$_SESSION['error'] = "Email o contraseña incorrectos";
header("Location: login.php");
exit;
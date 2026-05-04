<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Usuario logueado obligatorio
if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// FUNCIONES DE CONTROL

function esAdmin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

function esUsuario() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario';
}
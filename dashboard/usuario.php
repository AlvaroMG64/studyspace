<?php
require_once "../includes/auth.php";
require_once "../includes/header.php";
?>

<h2 class="text-2xl font-bold mb-4">Panel de Usuario</h2>

<a href="../reservas/crear.php" class="bg-green-500 text-white px-4 py-2 rounded">
    Crear reserva
</a>

<a href="../reservas/mis_reservas.php" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded">
    Mis reservas
</a>

<?php require_once "../includes/footer.php"; ?>
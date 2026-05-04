<?php
session_start();

// EVITAR entrar si ya está logueado
if (isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

require_once "../includes/helpers.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - StudySpace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded shadow-md w-96">

    <h2 class="text-2xl font-bold mb-4 text-center">Iniciar sesión</h2>

    <?php mensaje(); ?>

    <form action="procesar_login.php" method="POST">

        <input 
            type="email" 
            name="email" 
            placeholder="Correo electrónico"
            required
            class="w-full p-2 border rounded mb-3"
        >

        <input 
            type="password" 
            name="password" 
            placeholder="Contraseña"
            required
            class="w-full p-2 border rounded mb-3"
        >

        <button class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
            Entrar
        </button>

    </form>

    <p class="mt-4 text-center">
        ¿No tienes cuenta?
        <a href="registro.php" class="text-blue-500">Regístrate</a>
    </p>

</div>

</body>
</html>
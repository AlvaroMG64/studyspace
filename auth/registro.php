<?php
session_start();

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
    <title>Registro - StudySpace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded shadow-md w-96">

    <h2 class="text-2xl font-bold mb-4 text-center">Registro</h2>

    <?php mensaje(); ?>

    <form action="procesar_registro.php" method="POST" id="formRegistro">

        <input 
            type="text" 
            name="nombre" 
            placeholder="Nombre"
            required
            class="w-full p-2 border rounded mb-3"
        >

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

        <button class="w-full bg-green-500 text-white p-2 rounded hover:bg-green-600">
            Registrarse
        </button>

    </form>

    <p class="mt-4 text-center">
        ¿Ya tienes cuenta?
        <a href="login.php" class="text-blue-500">Inicia sesión</a>
    </p>

</div>

<script>
// Validación JS (contraseña segura)
document.getElementById("formRegistro").addEventListener("submit", function(e) {

    let nombre = document.querySelector("[name=nombre]").value.trim();
    let email = document.querySelector("[name=email]").value.trim();
    let pass = document.querySelector("[name=password]").value;

    let errores = [];

    if (nombre.length < 3) errores.push("Nombre mínimo 3 caracteres");

    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) errores.push("Email no válido");

    if (pass.length < 8) errores.push("Mínimo 8 caracteres");
    if (!/[A-Za-z]/.test(pass)) errores.push("Debe contener letras");
    if (!/[0-9]/.test(pass)) errores.push("Debe contener números");

    if (errores.length > 0) {
    alert(errores.join("\n"));
    e.preventDefault();
    }
});
</script>

</body>
</html>
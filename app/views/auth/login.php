<?php require_once "../core/helpers.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Login</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

<h1 class="text-3xl font-bold mb-6 text-center">
Iniciar sesión
</h1>

<?php mensaje(); ?>

<form method="POST" action="/studyspace/public/login">

<input
type="email"
name="email"
placeholder="Correo electrónico"
required
class="w-full p-3 border rounded-xl mb-4"
>

<input
type="password"
name="password"
placeholder="Contraseña"
required
class="w-full p-3 border rounded-xl mb-6"
>

<button
class="w-full bg-blue-600 text-white py-3 rounded-xl"
>
Entrar
</button>

</form>

<p class="mt-5 text-center">

¿No tienes cuenta?

<a
href="/studyspace/public/registro"
class="text-blue-600"
>

Regístrate

</a>

</p>

</div>

</body>
</html>
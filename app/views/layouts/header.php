<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>StudySpace</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-blue-700 text-white p-4 shadow">

    <div class="container mx-auto flex justify-between items-center">

        <a href="/studyspace/public/" class="font-bold text-xl">
            StudySpace
        </a>

        <div class="space-x-4">

            <?php if (isset($_SESSION['id'])): ?>

                <a href="/studyspace/public/mis-reservas" class="hover:underline">
                    Mis reservas
                </a>

                <a href="/studyspace/public/crear-reserva" class="hover:underline">
                    Crear reserva
                </a>

                <a href="/studyspace/public/logout" class="hover:underline">
                    Cerrar sesión
                </a>

            <?php else: ?>

                <a href="/studyspace/public/login" class="hover:underline">
                    Login
                </a>

                <a href="/studyspace/public/registro" class="hover:underline">
                    Registro
                </a>

            <?php endif; ?>

        </div>

    </div>

</nav>

<main class="container mx-auto py-8">
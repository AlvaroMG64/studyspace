<?php

declare(strict_types=1);

require_once "../app/views/layouts/header.php";
?>

<h1 class="text-4xl font-bold mb-2">
    Panel de administración
</h1>

<p class="text-gray-600 mb-8">
    Bienvenido,
    <span class="font-semibold">
        <?= htmlspecialchars($_SESSION['nombre']) ?>
    </span>
</p>

<!-- CARDS -->

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-2xl shadow-lg">

        <h2 class="text-gray-500 mb-2">
            Total reservas
        </h2>

        <p
            id="totalReservas"
            class="text-4xl font-bold text-blue-700"
        >
            0
        </p>

    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg">

        <h2 class="text-gray-500 mb-2">
            Usuarios
        </h2>

        <p
            id="totalUsuarios"
            class="text-4xl font-bold text-green-700"
        >
            0
        </p>

    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg">

        <h2 class="text-gray-500 mb-2">
            Mesas
        </h2>

        <p
            id="totalMesas"
            class="text-4xl font-bold text-indigo-700"
        >
            0
        </p>

    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg">

        <h2 class="text-gray-500 mb-2">
            Reservas hoy
        </h2>

        <p
            id="reservasHoy"
            class="text-4xl font-bold text-red-700"
        >
            0
        </p>

    </div>

</div>

<!-- GRAFICA -->

<div class="bg-white p-6 rounded-2xl shadow-lg mb-8">

    <h2 class="text-2xl font-bold mb-4">
        Estadísticas de reservas
    </h2>

    <canvas id="graficaReservas"></canvas>

</div>

<!-- FILTROS -->

<div class="bg-white p-6 rounded-2xl shadow-lg mb-8">

    <h2 class="text-2xl font-bold mb-6">
        Filtrar reservas
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <input
            type="text"
            id="filtroUsuario"
            placeholder="Buscar usuario"
            class="p-3 border rounded-xl"
        >

        <input
            type="date"
            id="filtroFecha"
            class="p-3 border rounded-xl"
        >

        <select
            id="filtroBiblioteca"
            class="p-3 border rounded-xl"
        >

            <option value="">
                Todas las bibliotecas
            </option>

        </select>

        <button
            class="bg-blue-600 text-white rounded-xl px-4 py-3 hover:bg-blue-700 transition"
        >
            Aplicar filtros
        </button>

    </div>

</div>

<!-- TABLA -->

<div class="bg-white p-6 rounded-2xl shadow-lg overflow-x-auto">

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold">
            Gestión de reservas
        </h2>

        <a
            href="/studyspace/public/crear-reserva"
            class="bg-green-600 text-white px-5 py-3 rounded-xl hover:bg-green-700 transition"
        >
            Nueva reserva
        </a>

    </div>

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4 text-left">
                    Usuario
                </th>

                <th class="p-4 text-left">
                    Fecha
                </th>

                <th class="p-4 text-left">
                    Horario
                </th>

                <th class="p-4 text-left">
                    Biblioteca
                </th>

                <th class="p-4 text-left">
                    Sala
                </th>

                <th class="p-4 text-left">
                    Mesa
                </th>

                <th class="p-4 text-left">
                    Acciones
                </th>

            </tr>

        </thead>

        <tbody id="tablaReservasAdmin">

            <tr class="border-t">

                <td class="p-4">
                    Usuario Demo
                </td>

                <td class="p-4">
                    2026-06-23
                </td>

                <td class="p-4">
                    17:00 - 18:00
                </td>

                <td class="p-4">
                    Biblioteca Central
                </td>

                <td class="p-4">
                    Sala 1
                </td>

                <td class="p-4">
                    Mesa 5
                </td>

                <td class="p-4 flex gap-4">

                    <a
                        href="#"
                        class="text-blue-600 hover:underline"
                    >
                        Editar
                    </a>

                    <button
                        class="text-red-600 hover:underline"
                    >
                        Eliminar
                    </button>

                </td>

            </tr>

        </tbody>

    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="/studyspace/resources/js/dashboard.js"></script>

<?php
require_once "../app/views/layouts/footer.php";
?>
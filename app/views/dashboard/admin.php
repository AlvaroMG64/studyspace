<?php

declare(strict_types=1);

require_once BASE_PATH . "/app/views/layouts/header.php";

if (!isset($reservas)) {
    $reservas = [];
}
?>

<h1 class="text-5xl font-bold mb-8 mt-8 font-display">
    Bienvenido, <span class="text-blue-700">
        <?= htmlspecialchars($_SESSION['nombre']) ?>
    </span>
</h1>

<p class="text-gray-500 text-xl mb-8">
    <span id="reloj" class="font-semibold text-blue-700"></span>
</p>

<h1 class="text-4xl font-bold mb-8 mt-8 font-display">
    Panel de administración
</h1>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow-lg">
        <h2 class="text-gray-500 mb-2">Total reservas</h2>
        <p id="totalReservas" class="text-5xl font-bold text-blue-700">0</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-lg">
        <h2 class="text-gray-500 mb-2">Usuarios</h2>
        <p id="totalUsuarios" class="text-5xl font-bold text-green-700">0</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-lg">
        <h2 class="text-gray-500 mb-2">Mesas</h2>
        <p id="totalMesas" class="text-5xl font-bold text-indigo-700">0</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-lg">
        <h2 class="text-gray-500 mb-2">Reservas hoy</h2>
        <p id="reservasHoy" class="text-5xl font-bold text-red-700">0</p>
    </div>

</div>

<div class="bg-white p-8 rounded-3xl shadow-lg mb-8">

    <h2 class="text-3xl font-bold mb-6 font-display">Estructura StudySpace</h2>

    <div id="studyspaceTree" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <p class="text-gray-500">Cargando estructura...</p>
    </div>

</div>

<div class="bg-white p-6 rounded-3xl shadow-lg mb-8">

    <h2 class="text-2xl font-bold mb-6 font-display">Estadísticas de reservas</h2>

    <canvas id="graficaReservas"></canvas>

</div>

<div class="bg-white p-6 rounded-3xl shadow-lg mb-8">

    <h2 class="text-2xl font-bold mb-6 font-display">Filtrar reservas</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <input type="text" id="filtroUsuario" placeholder="Buscar usuario" class="p-3 border rounded-2xl">
        <input type="date" id="filtroFecha" class="p-3 border rounded-2xl">
        <input type="text" id="filtroBiblioteca" placeholder="Buscar biblioteca" class="p-3 border rounded-2xl">

        <button type="button" id="btnLimpiarFiltros"
            class="bg-gray-200 rounded-2xl px-4 py-3 hover:bg-gray-300 transition">
            Limpiar filtros
        </button>

    </div>

</div>

<div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto">

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold font-display">Gestión de reservas</h2>

        <a href="<?= base_url('crear-reserva') ?>"
           class="bg-green-600 text-white px-5 py-3 rounded-2xl hover:bg-green-700 transition">
            Nueva reserva
        </a>

    </div>

    <table class="w-full">

        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">Usuario</th>
                <th class="p-4 text-left">Fecha</th>
                <th class="p-4 text-left">Horario</th>
                <th class="p-4 text-left">Biblioteca</th>
                <th class="p-4 text-left">Sala</th>
                <th class="p-4 text-left">Mesa</th>
                <th class="p-4 text-left">Acciones</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($reservas as $reserva): ?>

            <tr id="fila-<?= $reserva['id_reserva'] ?>"
                class="border-t filaReserva"

                data-usuario="<?= htmlspecialchars($reserva['nombre_u']) ?>"
                data-fecha="<?= htmlspecialchars($reserva['fecha_r']) ?>"
                data-biblioteca="<?= htmlspecialchars($reserva['nombre_b']) ?>"
                data-mesa="<?= (int)$reserva['numero'] ?>"
            >

                <td class="p-4"><?= htmlspecialchars($reserva['nombre_u']) ?></td>
                <td class="p-4"><?= htmlspecialchars($reserva['fecha_r']) ?></td>
                <td class="p-4">
                    <?= htmlspecialchars(substr((string)$reserva['hora_inicio'], 0, 5)) ?> -
                    <?= htmlspecialchars(substr((string)$reserva['hora_fin'], 0, 5)) ?>
                </td>
                <td class="p-4"><?= htmlspecialchars($reserva['nombre_b']) ?></td>
                <td class="p-4"><?= htmlspecialchars($reserva['nombre_s']) ?></td>
                <td class="p-4">Mesa <?= htmlspecialchars($reserva['numero']) ?></td>

                <td class="p-4 flex gap-4">

                    <a href="<?= base_url('editar-reserva?id=' . $reserva['id_reserva']) ?>"
                       class="text-blue-600 hover:underline">
                        Editar
                    </a>

                    <button data-id="<?= $reserva['id_reserva'] ?>"
                        class="btnEliminar text-red-600 hover:underline">
                        Eliminar
                    </button>

                </td>

            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url('assets/js/dashboard.js') ?>"></script>

<?php require_once BASE_PATH . "/app/views/layouts/footer.php"; ?>
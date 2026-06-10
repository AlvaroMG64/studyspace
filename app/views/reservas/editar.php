<?php

declare(strict_types=1);

require_once BASE_PATH . "/app/views/layouts/header.php";

if (!isset($reserva)) {
    $reserva = [];
}

if (!isset($bibliotecas)) {
    $bibliotecas = [];
}

$idBiblioteca = $reserva['id_biblioteca'] ?? 0;
$idSala = $reserva['id_sala'] ?? 0;
$idReserva = $reserva['id_reserva'] ?? 0;
$idMesa = $reserva['id_mesa'] ?? 0;
$numeroMesa = $reserva['numero'] ?? '';
$fecha = $reserva['fecha_r'] ?? '';

$horaInicio =
    isset($reserva['hora_inicio'])
        ? substr((string)$reserva['hora_inicio'], 0, 5)
        : '';

$horaFin =
    isset($reserva['hora_fin'])
        ? substr((string)$reserva['hora_fin'], 0, 5)
        : '';
?>

<div class="flex justify-center items-center min-h-[80vh]">

    <div class="bg-white w-full max-w-6xl rounded-3xl shadow-2xl p-10">

        <div class="mb-8 text-center">

            <h1 class="text-4xl font-bold font-display mb-2">
                Editar reserva
            </h1>

            <p class="text-gray-500">
                Modifica los datos de la reserva
            </p>

        </div>

        <div id="mensajeAjax" class="mb-6"></div>

        <form id="formEditar" method="POST" action="<?= base_url('actualizar-reserva') ?>" class="space-y-8">

            <input type="hidden" name="id"
                   value="<?= htmlspecialchars((string)$idReserva) ?>">

            <!-- FILA 1 -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- BIBLIOTECA -->
                <div>
                    <label class="block mb-2 font-medium">Biblioteca</label>

                    <select
                        id="biblioteca"
                        class="w-full border rounded-2xl p-4">

                        <option value="">Seleccionar biblioteca</option>

                        <?php foreach ($bibliotecas as $biblioteca): ?>

                            <option
                                value="<?= htmlspecialchars((string)$biblioteca['id_biblioteca']) ?>"
                                <?= $idBiblioteca == $biblioteca['id_biblioteca'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars((string)$biblioteca['nombre_b']) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>
                </div>

                <!-- SALA -->
                <div>
                    <label class="block mb-2 font-medium">Sala</label>

                    <select
                        id="sala"
                        data-selected="<?= htmlspecialchars((string)$idSala) ?>"
                        class="w-full border rounded-2xl p-4">

                        <option value="">Seleccionar sala</option>

                    </select>
                </div>

                <!-- MESA -->
                <div>
                    <label class="block mb-2 font-medium">Mesa</label>

                    <select
                        id="mesa"
                        data-selected="<?= htmlspecialchars((string)$idMesa) ?>"
                        name="mesa"
                        class="w-full border rounded-2xl p-4">

                        <?php if ($idMesa): ?>
                            <option value="<?= htmlspecialchars((string)$idMesa) ?>" selected>
                                Mesa <?= htmlspecialchars((string)$numeroMesa) ?>
                            </option>
                        <?php else: ?>
                            <option value="">Seleccionar mesa</option>
                        <?php endif; ?>

                    </select>
                </div>

            </div>

            <!-- FILA 2 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block mb-2 font-medium">Fecha</label>

                    <input type="date" name="fecha"
                           value="<?= htmlspecialchars((string)$fecha) ?>"
                           class="w-full border rounded-2xl p-4">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block mb-2 font-medium">Hora inicio</label>

                        <input type="time" name="inicio"
                               value="<?= htmlspecialchars((string)$horaInicio) ?>"
                               class="w-full border rounded-2xl p-4">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Hora fin</label>

                        <input type="time" name="fin"
                               value="<?= htmlspecialchars((string)$horaFin) ?>"
                               class="w-full border rounded-2xl p-4">
                    </div>

                </div>

            </div>

            <div class="flex justify-center gap-4 pt-4">

                <a href="<?= base_url('mis-reservas') ?>"
                   class="px-8 py-4 rounded-2xl bg-gray-200 hover:bg-gray-300 transition">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-8 py-4 rounded-2xl bg-blue-600 text-white hover:bg-blue-700 transition">
                    Guardar cambios
                </button>

            </div>

        </form>

    </div>
</div>

<script src="<?= base_url('assets/js/reservas.js') ?>"></script>

<?php require_once BASE_PATH . "/app/views/layouts/footer.php"; ?>
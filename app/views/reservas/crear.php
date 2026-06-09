<?php

declare(strict_types=1);

require_once "../app/views/layouts/header.php";

$bibliotecas = $bibliotecas ?? [];
?>

<div class="flex justify-center">

    <div class="w-full max-w-6xl">

        <h2 class="text-4xl font-bold mb-8 text-center font-display">
            Crear Reserva
        </h2>

        <form id="formReserva" class="bg-white p-10 rounded-3xl shadow-xl">

            <div id="mensajeAjax" class="mb-6"></div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>
                    <label class="font-semibold block mb-2">Biblioteca</label>

                    <select id="biblioteca" class="w-full p-3 border rounded-xl" required>
                        <option value="">Seleccionar biblioteca</option>

                        <?php foreach ($bibliotecas as $b): ?>
                            <option value="<?= (int)$b['id_biblioteca'] ?>">
                                <?= htmlspecialchars($b['nombre_b']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div>
                    <label class="font-semibold block mb-2">Sala</label>
                    <select id="sala" disabled class="w-full p-3 border rounded-xl">
                        <option value="">Seleccionar sala</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold block mb-2">Mesa</label>
                    <select id="mesa" name="mesa" disabled class="w-full p-3 border rounded-xl">
                        <option value="">Seleccionar mesa</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold block mb-2">Fecha</label>
                    <input type="date" name="fecha" min="<?= date('Y-m-d') ?>"
                        class="w-full p-3 border rounded-xl" required>
                </div>

                <div>
                    <label class="font-semibold block mb-2">Hora inicio</label>
                    <input type="time" name="inicio" class="w-full p-3 border rounded-xl" required>
                </div>

                <div>
                    <label class="font-semibold block mb-2">Hora fin</label>
                    <input type="time" name="fin" class="w-full p-3 border rounded-xl" required>
                </div>

            </div>

            <button type="submit"
                class="mt-10 w-full bg-blue-600 text-white py-4 rounded-2xl font-semibold">
                Crear reserva
            </button>

        </form>

    </div>

</div>

<script src="<?= base_url('assets/js/reservas.js') ?>"></script>

<?php require_once "../app/views/layouts/footer.php"; ?>
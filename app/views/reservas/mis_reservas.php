<?php

declare(strict_types=1);

/** @var mysqli_result $reservas */

require_once "../app/views/layouts/header.php";

?>

<h2 class="text-3xl font-bold mb-6">
    Mis Reservas
</h2>

<table class="w-full bg-white shadow rounded-xl overflow-hidden">

    <thead class="bg-gray-200">

        <tr>

            <th class="p-3 text-left">
                Fecha
            </th>

            <th class="p-3 text-left">
                Horario
            </th>

            <th class="p-3 text-left">
                Mesa
            </th>

            <th class="p-3 text-left">
                Sala
            </th>

            <th class="p-3 text-left">
                Biblioteca
            </th>

            <th class="p-3 text-left">
                Acciones
            </th>

        </tr>

    </thead>

    <tbody>

        <?php while ($r = $reservas->fetch_assoc()) : ?>

            <tr
                id="fila-<?= $r['id_reserva'] ?>"
                class="border-t"
            >

                <td class="p-3">
                    <?= htmlspecialchars($r['fecha_r']) ?>
                </td>

                <td class="p-3">

                    <?= htmlspecialchars($r['hora_inicio']) ?>

                    -

                    <?= htmlspecialchars($r['hora_fin']) ?>

                </td>

                <td class="p-3">
                    Mesa <?= htmlspecialchars($r['numero']) ?>
                </td>

                <td class="p-3">
                    <?= htmlspecialchars($r['nombre_s']) ?>
                </td>

                <td class="p-3">
                    <?= htmlspecialchars($r['nombre_b']) ?>
                </td>

                <td class="p-3 flex gap-4">

                    <a
                        href="/studyspace/public/editar-reserva?id=<?= $r['id_reserva'] ?>"
                        class="text-blue-600 hover:underline"
                    >
                        Editar
                    </a>

                    <button
                        class="text-red-600 btnEliminar"
                        data-id="<?= $r['id_reserva'] ?>"
                    >
                        Eliminar
                    </button>

                </td>

            </tr>

        <?php endwhile; ?>

    </tbody>

</table>

<div id="mensajeAjax" class="mt-4"></div>

<script src="/studyspace/resources/js/reservas.js"></script>

<?php

require_once "../app/views/layouts/footer.php";
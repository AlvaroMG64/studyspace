<?php require_once "../app/views/layouts/header.php"; ?>

<?php require_once "../includes/helpers.php"; ?>

<h2 class="text-2xl font-bold mb-4">
Mis Reservas
</h2>

<?php mensaje(); ?>

<table class="w-full bg-white shadow rounded">

<tr class="bg-gray-200">

<th class="p-2">
Fecha
</th>

<th class="p-2">
Hora
</th>

<th class="p-2">
Mesa
</th>

<th class="p-2">
Biblioteca
</th>

<th class="p-2">
Sala
</th>

<th class="p-2">
Acciones
</th>

</tr>

<?php while ($r = $reservas->fetch_assoc()) { ?>

<tr
id="fila-<?= $r['id_reserva'] ?>"
class="border-t text-center"
>

<td>
<?= htmlspecialchars($r['fecha_r']) ?>
</td>

<td>

<?= htmlspecialchars($r['hora_inicio']) ?>

-

<?= htmlspecialchars($r['hora_fin']) ?>

</td>

<td>
<?= htmlspecialchars($r['numero']) ?>
</td>

<td>
<?= htmlspecialchars($r['nombre_b']) ?>
</td>

<td>
<?= htmlspecialchars($r['nombre_s']) ?>
</td>

<td>

<a
href="/studyspace/public/editar-reserva?id=<?= $r['id_reserva'] ?>"
class="text-blue-500"
>

Editar

</a>

|

<a
href="#"
class="text-red-500 btnEliminar"
data-id="<?= $r['id_reserva'] ?>"
>

Eliminar

</a>

</td>

</tr>

<?php } ?>

</table>

<script src="/studyspace/resources/js/reservas.js"></script>

<?php require_once "../app/views/layouts/footer.php"; ?>
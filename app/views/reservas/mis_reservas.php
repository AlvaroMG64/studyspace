<?php
require_once "../includes/auth.php";
require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/helpers.php";

$conn = Database::connect();

$id = $_SESSION['id'];

$stmt = $conn->prepare("
SELECT r.*, m.numero 
FROM reservas r
JOIN mesas m ON r.id_mesa = m.id_mesa
WHERE r.id_usuario = ?
ORDER BY fecha_r DESC, hora_inicio ASC
");

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2 class="text-2xl font-bold mb-4">Mis Reservas</h2>

<?php mensaje(); ?>

<table class="w-full bg-white shadow rounded">

<tr class="bg-gray-200">
<th class="p-2">Fecha</th>
<th class="p-2">Hora</th>
<th class="p-2">Mesa</th>
<th class="p-2">Acciones</th>
</tr>

<?php while ($r = $result->fetch_assoc()) { ?>
<tr id="fila-<?= $r['id_reserva'] ?>" class="border-t text-center">

<td><?= htmlspecialchars($r['fecha_r']) ?></td>

<td>
<?= htmlspecialchars($r['hora_inicio']) ?>
-
<?= htmlspecialchars($r['hora_fin']) ?>
</td>

<td><?= htmlspecialchars($r['numero']) ?></td>

<td>

<a href="/studyspace/public/editar-reserva?id=<?= $r['id_reserva'] ?>"
class="text-blue-500">
Editar
</a>

|

<a href="#"
class="text-red-500 btnEliminar"
data-id="<?= $r['id_reserva'] ?>">
Eliminar
</a>

</td>

</tr>
<?php } ?>

</table>

<script src="/studyspace/resources/js/reservas.js"></script>

<?php require_once "../includes/footer.php"; ?>
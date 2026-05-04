<?php
require_once "../includes/auth.php";
require_once "../includes/header.php";
require_once "../config/db.php";
require_once "../includes/helpers.php";

if (!esAdmin()) {
    header("Location: ../index.php");
    exit;
}

// FILTRO
$fechaFiltro = $_GET['fecha'] ?? '';

// PAGINACIÓN
$limite = 10;
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$offset = ($pagina - 1) * $limite;

// QUERY BASE
$sqlBase = "
FROM reservas r
JOIN usuarios u ON r.id_usuario = u.id_usuario
JOIN mesas m ON r.id_mesa = m.id_mesa
";

// FILTRO FECHA
if ($fechaFiltro) {
    $sqlBase .= " WHERE fecha_r = ?";
}

// TOTAL REGISTROS
if ($fechaFiltro) {
    $stmt = $conn->prepare("SELECT COUNT(*) as total $sqlBase");
    $stmt->bind_param("s", $fechaFiltro);
} else {
    $stmt = $conn->prepare("SELECT COUNT(*) as total $sqlBase");
}

$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];

// TOTAL PÁGINAS
$totalPaginas = max(1, ceil($total / $limite));

// OBTENER DATOS
$sql = "
SELECT r.*, u.nombre_u, m.numero
$sqlBase
ORDER BY fecha_r DESC, hora_inicio ASC
LIMIT ? OFFSET ?
";

if ($fechaFiltro) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $fechaFiltro, $limite, $offset);
} else {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $limite, $offset);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<h2 class="text-2xl font-bold mb-6">Panel de Administrador</h2>

<?php mensaje(); ?>

<div class="flex justify-between items-center mb-4">

    <a href="../reservas/crear.php" 
       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Nueva reserva
    </a>

    <form method="GET" class="flex gap-2">
        <input type="date" name="fecha" value="<?= htmlspecialchars($fechaFiltro) ?>"
               class="border p-2 rounded">
        <button class="bg-gray-500 text-white px-3 rounded">Filtrar</button>
        <a href="admin.php" class="bg-red-500 text-white px-3 rounded">Reset</a>
    </form>

</div>

<div class="overflow-x-auto">
<table class="w-full bg-white shadow rounded">

<tr class="bg-gray-200">
    <th class="p-3">Usuario</th>
    <th class="p-3">Fecha</th>
    <th class="p-3">Hora</th>
    <th class="p-3">Mesa</th>
    <th class="p-3 text-center">Acciones</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr class="border-t text-center">

<td><?= htmlspecialchars($row['nombre_u']) ?></td>
<td><?= htmlspecialchars($row['fecha_r']) ?></td>
<td><?= htmlspecialchars($row['hora_inicio']) ?> - <?= htmlspecialchars($row['hora_fin']) ?></td>
<td><?= htmlspecialchars($row['numero']) ?></td>

<td>
<a href="../reservas/editar.php?id=<?= $row['id_reserva'] ?>" class="text-blue-500">Editar</a> |
<a href="../reservas/eliminar.php?id=<?= $row['id_reserva'] ?>" 
   onclick="return confirm('¿Eliminar reserva?')" 
   class="text-red-500">Eliminar</a>
</td>

</tr>
<?php } ?>

</table>
</div>

<!-- PAGINACIÓN -->
<div class="mt-4 flex justify-center gap-2">

<?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
<a href="?pagina=<?= $i ?>&fecha=<?= urlencode($fechaFiltro) ?>"
   class="px-3 py-1 border rounded <?= $i == $pagina ? 'bg-blue-500 text-white' : '' ?>">
   <?= $i ?>
</a>
<?php } ?>

</div>

<?php require_once "../includes/footer.php"; ?>
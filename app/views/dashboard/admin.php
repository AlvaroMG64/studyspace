<?php

declare(strict_types=1);

require_once __DIR__ . '/../layouts/header.php';
?>

<h1 class="text-4xl font-bold mb-8">

Panel de administración

</h1>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

<div class="bg-white p-6 rounded-2xl shadow-lg">

<h2 class="text-gray-500 mb-2">
Total reservas
</h2>

<p
id="totalReservas"
class="text-4xl font-bold"
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
class="text-4xl font-bold"
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
class="text-4xl font-bold"
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
class="text-4xl font-bold"
>
0
</p>

</div>

</div>

<div class="bg-white p-6 rounded-2xl shadow-lg">

<canvas id="graficaReservas"></canvas>

</div>

<script src="/studyspace/resources/js/dashboard.js"></script>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
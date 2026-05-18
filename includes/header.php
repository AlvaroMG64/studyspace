<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>StudySpace</title>

<script src="https://cdn.tailwindcss.com"></script>

<!-- FUENTES -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

<style>

body {
    font-family: 'Roboto', sans-serif;
    background: #f3f4f6;
}

h1,h2,h3,h4,h5,h6 {
    font-family: 'Poppins', sans-serif;
}

/* BOTONES */

.btn {
    padding: 10px 18px;
    border-radius: 14px;
    color: white;
    font-weight: 500;
    transition: .25s;
    display: inline-block;
}

.btn:hover {
    transform: translateY(-2px);
    opacity: .95;
}

.btn-blue {
    background: linear-gradient(135deg,#2563eb,#1d4ed8);
}

.btn-green {
    background: linear-gradient(135deg,#10b981,#059669);
}

.btn-red {
    background: linear-gradient(135deg,#ef4444,#dc2626);
}

.btn-gray {
    background: linear-gradient(135deg,#6b7280,#4b5563);
}

/* CARDS */

.card {
    background: white;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 5px 18px rgba(0,0,0,.08);
}

/* MODAL */

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-box {
    background: white;
    padding: 30px;
    border-radius: 20px;
    width: 90%;
    max-width: 400px;
}

</style>

</head>

<body>

<nav class="bg-blue-600 text-white p-4 shadow">

<div class="max-w-7xl mx-auto flex justify-between items-center">

<h1 class="text-2xl font-bold">
📚 StudySpace
</h1>

<div class="flex items-center gap-4">

<span class="font-medium">
<?= htmlspecialchars($_SESSION['nombre'] ?? '') ?>
</span>

<a href="../auth/logout.php" class="btn btn-red">
Salir
</a>

</div>

</div>

</nav>

<div class="max-w-7xl mx-auto p-6">
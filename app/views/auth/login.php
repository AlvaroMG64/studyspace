<?php require_once BASE_PATH . "/core/helpers.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>StudySpace - Login</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

<link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png?v=1') ?>">

<style>
body { font-family: 'Roboto', sans-serif; }
h1, h2 { font-family: 'Poppins', sans-serif; }

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-in {
    animation: fadeIn 0.6s ease-out;
}
</style>
</head>

<body class="min-h-screen flex">

<div class="hidden lg:flex w-1/2 bg-gradient-to-br from-blue-600 via-indigo-600 to-blue-800 text-white p-20 flex-col justify-center">

    <img src="<?= base_url('assets/img/logo.png') ?>" class="w-64 h-64 mb-8 drop-shadow-xl">

    <h1 class="text-5xl font-bold mb-4">StudySpace</h1>

    <p class="text-white/80 text-xl leading-relaxed">
        Sistema de reservas para bibliotecas y salas de estudio
    </p>

</div>

<div class="w-full lg:w-1/2 flex items-center justify-center p-10
bg-[radial-gradient(circle_at_20%_20%,#dbeafe,transparent_40%),linear-gradient(to_bottom,#f8fafc,#eef2ff)]">

    <div class="animate-in w-full max-w-md">

        <div class="text-center mb-10">

            <img src="<?= base_url('assets/img/logo.png') ?>"
                 class="w-36 h-36 mx-auto mb-6 drop-shadow-xl">

            <h2 class="text-4xl font-bold text-slate-900">Iniciar sesión</h2>
            <p class="text-slate-500 text-base mt-2">Accede a tu cuenta</p>

        </div>

        <?php mensaje(); ?>

        <form method="POST" action="<?= base_url('login') ?>" class="space-y-5">

            <input type="email" name="email" required placeholder="Correo electrónico"
                class="w-full p-4 text-lg rounded-xl border border-slate-200 bg-white/70
                focus:ring-2 focus:ring-blue-500 focus:outline-none transition">

            <input type="password" name="password" required placeholder="Contraseña"
                class="w-full p-4 text-lg rounded-xl border border-slate-200 bg-white/70
                focus:ring-2 focus:ring-blue-500 focus:outline-none transition">

            <button class="w-full py-4 rounded-xl
                bg-gradient-to-r from-blue-600 to-indigo-700
                text-white font-semibold text-lg
                shadow-lg hover:scale-[1.02] active:scale-[0.98]
                transition">
                Entrar
            </button>

        </form>

        <p class="mt-6 text-center text-slate-500 text-sm">
            ¿No tienes cuenta?
            <a href="<?= base_url('registro') ?>" class="text-blue-600 font-semibold hover:underline">
                Regístrate
            </a>
        </p>

    </div>

</div>

</body>
</html>
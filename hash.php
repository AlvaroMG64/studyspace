<?php

$password1 = "Admin2026*";
$hash1 = password_hash($password1, PASSWORD_DEFAULT);

$password2 = "User2026*";
$hash2 = password_hash($password2, PASSWORD_DEFAULT);

$sql = "
INSERT INTO usuarios (
    nombre_u,
    email,
    contrasena,
    rol
)
VALUES
(
    'Administrador',
    'admin@studyspace.com',
    '$hash1',
    'admin'
),
(
    'Usuario Demo',
    'user@studyspace.com',
    '$hash2',
    'usuario'
);
";

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Generador SQL</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: white;
    padding: 30px;
}

pre {
    background: #f0f0f0;
    color: black;
    padding: 20px;
    border-radius: 10px;
    overflow-x: auto;
    font-size: 15px;
    line-height: 1.5;
}
</style>

</head>
<body>

<h2>SQL generado</h2>

<pre><?= htmlspecialchars($sql) ?></pre>

</body>
</html>
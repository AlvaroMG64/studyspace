USE studyspace;

-- USUARIOS

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
    '$2y$10$5KnejANxWeAOLP3/K6HyauPFeWAndCJTwuFMYyeG.VIuM.JQPG6uq',
    'admin'
),
(
    'Usuario Demo',
    'user@studyspace.com',
    '$2y$10$Jqjjqj4K5s.YBunblT8ka.7ed5ksVCk/WaiXyhPClcGxpW2Blu0oC',
    'usuario'
);

-- BIBLIOTECAS

INSERT INTO bibliotecas (
    nombre_b,
    direccion
)
VALUES
(
    'Biblioteca Central',
    'Calle Principal 123'
),
(
    'Biblioteca Norte',
    'Avenida Andalucía 45'
);

-- SALAS

INSERT INTO salas (
    nombre_s,
    capacidad,
    id_biblioteca
)
VALUES
(
    'Sala 1',
    20,
    1
),
(
    'Sala 2',
    15,
    1
),
(
    'Sala Norte',
    10,
    2
);

-- MESAS

INSERT INTO mesas (
    numero,
    id_sala
)
VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(5, 2),
(6, 3);

-- RESERVAS

INSERT INTO reservas (
    fecha_r,
    hora_inicio,
    hora_fin,
    id_usuario,
    id_mesa
)
VALUES
(
    '2026-05-20',
    '09:00:00',
    '11:00:00',
    2,
    1
),
(
    '2026-05-21',
    '16:00:00',
    '18:00:00',
    2,
    2
),
(
    '2026-05-22',
    '10:00:00',
    '12:00:00',
    1,
    3
);
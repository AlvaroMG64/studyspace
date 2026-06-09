USE studyspace;

-- =========================
-- USUARIOS
-- =========================

INSERT INTO usuarios (id_usuario, nombre_u, email, contrasena, rol)
VALUES
(1, 'Administrador', 'admin@studyspace.com', '$2y$10$5B9qpE3FPEAgxhNpattWdeibtoFaPMJ7j9czagaHgwzUjS9uNz8ay', 'admin'),
(2, 'Usuario Demo', 'user@studyspace.com', '$2y$10$/cVfY3bW2VeETEM2/TE/leyyseh6P5xZopNTdit7Y/subMRPj8QSK', 'usuario'),
(3, 'Federico Zompicchiatti', 'zazzaelitaliano@gmail.com', '$2y$10$zXwotRclri4c7vtq9pLuuuAfOfRZJBZ7c6bozerCv3eJwcSmKG9hq', 'usuario'),
(4, 'Elliot Dalton', 'elliotdalton@gmail.com', '$2y$10$jF7nNeh0tLSTLoWn5.x/ee4CfefF8raOheLXSN.it74oIfWuu8/XG', 'usuario'),
(5, 'Admin 2', 'admin2@studyspace.com', '$2y$10$RIdcxWSVL2cPXfWffUa.suKJc8qF4FYFZTYhIx7oQSDm7Sp5g4GEK', 'admin');

-- ID: 1 | PASSWORD: Admin2026* | HASH: $2y$10$5B9qpE3FPEAgxhNpattWdeibtoFaPMJ7j9czagaHgwzUjS9uNz8ay
-- ID: 2 | PASSWORD: Echchahed5_ | HASH: $2y$10$/cVfY3bW2VeETEM2/TE/leyyseh6P5xZopNTdit7Y/subMRPj8QSK
-- ID: 3 | PASSWORD: Abduzcan73* | HASH: $2y$10$zXwotRclri4c7vtq9pLuuuAfOfRZJBZ7c6bozerCv3eJwcSmKG9hq
-- ID: 4 | PASSWORD: Nabaskues9_ | HASH: $2y$10$jF7nNeh0tLSTLoWn5.x/ee4CfefF8raOheLXSN.it74oIfWuu8/XG
-- ID: 5 | PASSWORD: AdminStudy26* | HASH: $2y$10$RIdcxWSVL2cPXfWffUa.suKJc8qF4FYFZTYhIx7oQSDm7Sp5g4GEK

-- =========================
-- BIBLIOTECAS
-- =========================
INSERT INTO bibliotecas (id_biblioteca, nombre_b, direccion)
VALUES
(1, 'Biblioteca Central de Málaga', 'Calle Larios 12, Málaga'),
(2, 'Biblioteca Municipal La Palma', 'Avenida de Andalucía 45, Málaga'),
(3, 'Biblioteca Barrio El Palo', 'Calle Playa del Palo 8, Málaga');

-- =========================
-- SALAS
-- =========================
INSERT INTO salas (id_sala, nombre_s, capacidad, id_biblioteca)
VALUES
(1, 'Sala de Lectura', 25, 1),
(2, 'Sala Silenciosa', 20, 1),
(3, 'Sala de Consulta', 15, 1),

(4, 'Sala General', 30, 2),
(5, 'Sala de Estudio', 18, 2),

(6, 'Sala Principal', 22, 3),
(7, 'Sala de Trabajo', 12, 3);

-- =========================
-- MESAS
-- =========================
INSERT INTO mesas (id_mesa, numero, id_sala)
VALUES
-- Sala 1
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),

-- Sala 2
(5, 1, 2),
(6, 2, 2),
(7, 3, 2),

-- Sala 3
(8, 1, 3),
(9, 2, 3),

-- Sala 4
(10, 1, 4),
(11, 2, 4),
(12, 3, 4),
(13, 4, 4),

-- Sala 5
(14, 1, 5),
(15, 2, 5),
(16, 3, 5),

-- Sala 6
(17, 1, 6),
(18, 2, 6),
(19, 3, 6),

-- Sala 7
(20, 1, 7),
(21, 2, 7);

ALTER TABLE usuarios AUTO_INCREMENT = 6;
ALTER TABLE bibliotecas AUTO_INCREMENT = 4;
ALTER TABLE salas AUTO_INCREMENT = 8;
ALTER TABLE mesas AUTO_INCREMENT = 22;

-- =========================
-- INCIDENCIAS
-- =========================
INSERT INTO incidencias (descripcion, fecha_i, id_usuario)
VALUES
('Pantalla rota en sala principal', '2026-06-01', 2);

-- =========================
-- RESERVAS
-- =========================

INSERT INTO reservas (id_reserva, fecha_r, hora_inicio, hora_fin, id_usuario, id_mesa)
VALUES
(1,  '2026-06-20', '09:00:00', '11:00:00', 2, 1),
(2,  '2026-06-20', '11:30:00', '13:30:00', 3, 2),
(3,  '2026-06-20', '16:00:00', '18:00:00', 1, 3),

(4,  '2026-06-21', '09:00:00', '11:00:00', 4, 5),
(5,  '2026-06-21', '11:30:00', '13:30:00', 2, 6),
(6,  '2026-06-21', '17:00:00', '19:00:00', 1, 7),

(7,  '2026-06-22', '10:00:00', '12:00:00', 3, 10),
(8,  '2026-06-22', '12:30:00', '14:30:00', 5, 12),
(9,  '2026-06-22', '16:00:00', '18:00:00', 1, 11),

(10, '2026-06-23', '09:30:00', '11:30:00', 4, 15),
(11, '2026-06-23', '12:00:00', '14:00:00', 2, 16),
(12, '2026-06-23', '18:00:00', '20:00:00', 1, 14),

(13, '2026-06-24', '08:00:00', '10:00:00', 3, 20),
(14, '2026-06-24', '10:30:00', '12:30:00', 5, 21),
(15, '2026-06-24', '16:00:00', '18:00:00', 2, 19),

(16, '2026-06-25', '09:00:00', '11:00:00', 1, 4),
(17, '2026-06-25', '11:30:00', '13:30:00', 3, 8),
(18, '2026-06-25', '17:00:00', '19:00:00', 4, 9),

(19, '2026-06-26', '09:00:00', '11:00:00', 2, 13),
(20, '2026-06-26', '11:30:00', '13:30:00', 5, 17),
(21, '2026-06-26', '16:00:00', '18:00:00', 1, 18),

(22, '2026-06-27', '09:00:00', '11:00:00', 2, 1),
(23, '2026-06-27', '17:00:00', '19:00:00', 3, 6),
(24, '2026-06-28', '10:00:00', '12:00:00', 1, 10),
(25, '2026-06-30', '16:00:00', '18:00:00', 5, 14);
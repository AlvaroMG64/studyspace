DROP DATABASE IF EXISTS studyspace;

CREATE DATABASE studyspace
CHARACTER SET utf8mb4
COLLATE utf8mb4_spanish_ci;

USE studyspace;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_u VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') DEFAULT 'usuario'
) ENGINE=InnoDB;

CREATE TABLE bibliotecas (
    id_biblioteca INT AUTO_INCREMENT PRIMARY KEY,
    nombre_b VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE salas (
    id_sala INT AUTO_INCREMENT PRIMARY KEY,
    nombre_s VARCHAR(100) NOT NULL,
    capacidad INT NOT NULL,
    id_biblioteca INT NOT NULL,
    INDEX (id_biblioteca),
    FOREIGN KEY (id_biblioteca) 
        REFERENCES bibliotecas(id_biblioteca)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE mesas (
    id_mesa INT AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL,
    id_sala INT NOT NULL,
    INDEX (id_sala),
    FOREIGN KEY (id_sala) 
        REFERENCES salas(id_sala)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    fecha_r DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    id_usuario INT NOT NULL,
    id_mesa INT NOT NULL,
    INDEX (id_usuario),
    INDEX (id_mesa),
    FOREIGN KEY (id_usuario) 
        REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_mesa) 
        REFERENCES mesas(id_mesa)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE incidencias (
    id_incidencia INT AUTO_INCREMENT PRIMARY KEY,
    descripcion TEXT NOT NULL,
    fecha_i DATE NOT NULL,
    id_usuario INT NULL,
    INDEX (id_usuario),
    FOREIGN KEY (id_usuario) 
        REFERENCES usuarios(id_usuario)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB;
<?php

declare(strict_types=1);

// =========================
// HOME
// =========================

$router->get(
    "/",
    "AuthController@home"
);

// =========================
// AUTH
// =========================

$router->get(
    "/login",
    "AuthController@login"
);

$router->post(
    "/login",
    "AuthController@autenticar"
);

$router->get(
    "/registro",
    "AuthController@registro"
);

$router->post(
    "/registro",
    "AuthController@guardarRegistro"
);

$router->get(
    "/logout",
    "AuthController@logout"
);

// =========================
// RESERVAS
// =========================

$router->get(
    "/mis-reservas",
    "ReservaController@misReservas"
);

$router->get(
    "/crear-reserva",
    "ReservaController@crear"
);

$router->post(
    "/guardar-reserva",
    "ReservaController@guardar"
);

$router->get(
    "/editar-reserva",
    "ReservaController@editar"
);

$router->post(
    "/actualizar-reserva",
    "ReservaController@actualizar"
);

$router->post(
    "/eliminar-reserva",
    "ReservaController@eliminar"
);

// =========================
// ADMIN
// =========================

$router->get(
    "/admin",
    "AdminController@dashboard"
);
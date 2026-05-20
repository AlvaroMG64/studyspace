<?php

require_once "../app/controllers/AuthController.php";
require_once "../app/controllers/ReservaController.php";

// AUTH

$router->get(
    '/',
    'AuthController@home'
);

$router->get(
    '/login',
    'AuthController@login'
);

$router->post(
    '/login',
    'AuthController@autenticar'
);

$router->get(
    '/registro',
    'AuthController@registro'
);

$router->post(
    '/registro',
    'AuthController@guardarRegistro'
);

$router->get(
    '/logout',
    'AuthController@logout'
);

// RESERVAS

$router->get(
    '/mis-reservas',
    'ReservaController@misReservas'
);

$router->get(
    '/crear-reserva',
    'ReservaController@crear'
);

$router->post(
    '/guardar-reserva',
    'ReservaController@guardar'
);

$router->get(
    '/editar-reserva',
    'ReservaController@editar'
);

$router->post(
    '/actualizar-reserva',
    'ReservaController@actualizar'
);

$router->post(
    '/eliminar-reserva',
    'ReservaController@eliminar'
);
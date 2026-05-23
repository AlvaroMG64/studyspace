<?php

declare(strict_types=1);

require_once __DIR__ .
    '/../app/controllers/ApiController.php';

// API SALAS
$router->get(
    '/api/salas',
    'ApiController@salas'
);

// API MESAS
$router->get(
    '/api/mesas',
    'ApiController@mesas'
);

// API STATS
$router->get(
    '/api/stats',
    'ApiController@stats'
);

// API ELIMINAR RESERVA
$router->post(
    '/api/eliminar-reserva',
    'ApiController@eliminarReserva'
);
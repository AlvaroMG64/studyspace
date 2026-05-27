<?php

require_once "../app/controllers/ApiController.php";

$router->get('/api/salas', 'ApiController@salas');
$router->get('/api/mesas', 'ApiController@mesas');
$router->get('/api/stats', 'ApiController@stats');

$router->post('/api/eliminar-reserva', 'ReservaController@eliminar');
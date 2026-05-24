<?php

declare(strict_types=1);

require_once "../app/controllers/ApiController.php";

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
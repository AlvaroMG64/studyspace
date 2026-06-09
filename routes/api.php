<?php

declare(strict_types=1);

// DASHBOARD
$router->get("api/stats", "ApiController@stats");

// SALAS
$router->get("api/salas", "SalaController@obtenerPorBiblioteca");

// MESAS
$router->get("api/mesas", "MesaController@obtenerPorSala");

// TREE
$router->get("api/bibliotecas-tree", "ApiController@bibliotecasTree");

// MIS RESERVAS API
$router->get("api/mis-reservas", "ReservaController@misReservasApi");
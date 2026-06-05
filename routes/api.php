<?php

declare(strict_types=1);

$router->get(
    "/api/stats",
    "ApiController@stats"
);

$router->get(
    "/api/salas",
    "SalaController@obtenerPorBiblioteca"
);

$router->get(
    "/api/mesas",
    "MesaController@obtenerPorSala"
);
<?php

declare(strict_types=1);

// =========================
// DASHBOARD STATS
// =========================

$router->get(
    "/api/stats",
    "ApiController@stats"
);

// =========================
// BIBLIOTECAS → SALAS
// =========================

$router->get(
    "/api/salas",
    "SalaController@obtenerPorBiblioteca"
);

// =========================
// SALAS → MESAS
// =========================

$router->get(
    "/api/mesas",
    "MesaController@obtenerPorSala"
);

// =========================
// ÁRBOL VISUAL STUDYSPACE
// =========================

$router->get(
    "/api/bibliotecas-tree",
    "ApiController@bibliotecasTree"
);

$router->get(
    "/api/dashboard",
    "ApiController@stats"
);
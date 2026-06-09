<?php

declare(strict_types=1);

// =========================
// SESIÓN SEGURA
// =========================
ini_set('session.gc_maxlifetime', 1800);
ini_set('session.cookie_lifetime', 0);

session_start();

require_once "../core/helpers.php";
require_once "../core/Router.php";
require_once "../core/Model.php";

$router = new Router();

require_once "../routes/web.php";
require_once "../routes/api.php";

$router->dispatch();
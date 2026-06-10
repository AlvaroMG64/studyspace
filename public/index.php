<?php

declare(strict_types=1);

// =========================
// CONFIG GLOBAL
// =========================

// Ruta base del proyecto (RAÍZ)
define('BASE_PATH', dirname(__DIR__));

// =========================
// SESIÓN SEGURA
// =========================
ini_set('session.gc_maxlifetime', 1800);
ini_set('session.cookie_lifetime', 0);

session_start();

// =========================
// CORE SYSTEM
// =========================
require_once BASE_PATH . "/core/helpers.php";
require_once BASE_PATH . "/core/Router.php";
require_once BASE_PATH . "/core/Model.php";

// =========================
// ROUTER INIT
// =========================
$router = new Router();

// =========================
// ROUTES
// =========================
require_once BASE_PATH . "/routes/web.php";
require_once BASE_PATH . "/routes/api.php";

// =========================
// DISPATCH
// =========================
$router->dispatch();
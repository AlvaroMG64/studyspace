<?php

// Asegurar sesión siempre
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function mensaje() {

    if (isset($_SESSION['error'])) {
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>
                " . htmlspecialchars($_SESSION['error']) . "
              </div>";
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {
        echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4'>
                " . htmlspecialchars($_SESSION['success']) . "
              </div>";
        unset($_SESSION['success']);
    }
}
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function mensaje() {

    if (isset($_SESSION['error'])) {

        echo '
        <div class="mb-5 p-4 rounded-xl bg-red-100 border border-red-400 text-red-700">
            ' . htmlspecialchars($_SESSION['error']) . '
        </div>';

        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {

        echo '
        <div class="mb-5 p-4 rounded-xl bg-green-100 border border-green-400 text-green-700">
            ' . htmlspecialchars($_SESSION['success']) . '
        </div>';

        unset($_SESSION['success']);
    }
}
<?php

declare(strict_types=1);

require_once "../core/Controller.php";

require_once "../app/models/Reserva.php";

class AdminController extends Controller {

    public function dashboard(): void
    {
        if (
            !isset($_SESSION['rol'])
            || $_SESSION['rol'] !== 'admin'
        ) {

            header(
                "Location: /studyspace/public/"
            );

            exit;
        }

        $reservaModel =
            new Reserva();

        $reservas =
            $reservaModel
                ->obtenerTodas()
                ->fetch_all(MYSQLI_ASSOC);

        $this->view(
            "dashboard/admin",
            [
                "reservas" => $reservas
            ]
        );
    }
}
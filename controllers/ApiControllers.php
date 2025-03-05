<?php
namespace Controllers;

use Model\Servicio;

class ApiControllers {
    public static function index() {
        $servicios = Servicio::all(); 
        echo json_encode($servicios);
    }

    public static function guardar() {
        $respuesta = [
            'mensaje' => 'Todo waos'
        ];

        echo json_encode($respuesta);
    }
}


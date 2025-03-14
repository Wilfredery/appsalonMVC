<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController {
    public static function index(Router $router) {
        isSession();
        isAuth();

        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }
    public static function crear(Router $router) {
        isSession();
        isAuth();

        $servicio = new Servicio;
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $servicio->sincronizar($_POST);
            $errores = $servicio->validar();

            if(empty($errores)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router) {
        isSession();
        isAuth();
        
        if(!is_numeric($_GET['id'])) return;

        $servicio = Servicio::find($_GET['id']);
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $servicio->sincronizar($_POST);
            $errores = $servicio->validar();

            if(empty($errores)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'errores' => $errores
        ]);
    }

    public static function eliminar() {
        isSession();
        isAuth();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            $servicio->eliminar();
            header('Location: /servicios');
        }

    }
}
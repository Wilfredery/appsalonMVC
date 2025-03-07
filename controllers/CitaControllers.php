<?php

namespace Controllers;
use MVC\Router;

class CitaControllers {

    public static function index(Router $router) {

        //Con esto puedes visualizar utilizando el debu($_SESSION);
        if (!isset($_SESSION['nombre'])){
            header('Location: /');
        } 

        isAuth();
        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}


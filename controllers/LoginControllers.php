<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginControllers {
    public static function login(Router $router) {
        

        $router->render('auth/login');
    }

    public static function logout(Router $router) {
        echo "Era lo ma duro del sistema.";
    }

    public static function olvidar(Router $router) {
        $router->render('auth/olvidar', []);
    }

    public static function recuperar(Router $router) {
        echo "Se recupero la contra.";
    }

    public static function crear(Router $router) {
        
        $usuario = new Usuario;

        //Alertas vacias
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
         
            $usuario->sincronizar($_POST);
            $errores = $usuario->validarNewAcc();
            
            
        }
        
        $router->render('auth/crear' , [
            'usuario' => $usuario,
            'errores' => $errores
        ]);
    }
}
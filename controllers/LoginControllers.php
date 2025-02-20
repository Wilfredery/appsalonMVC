<?php

namespace Controllers;

use Classes\Email;
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
            
            
            //Revisar si esta vacio
            if(empty($errores)) {
                
                // Verificar que el usuario no este registrado

                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $errores = Usuario::geterrores();

                } else {
                    //Hashear el password
                    $usuario->hashPassword();
                    
                    

                    // Generar un token unico
                    $usuario->crearToken();

                    //Enviar el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->confirmarToken();

                    //Creando el usuario
                    $resultadp = $usuario->guardar();

                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        
        $router->render('auth/crear' , [
            'usuario' => $usuario,
            'errores' => $errores
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }
}
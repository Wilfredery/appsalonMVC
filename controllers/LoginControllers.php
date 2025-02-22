<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginControllers {
    public static function login(Router $router) {
        
        $errores =[];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $auth = new Usuario($_POST);
            $errores = $auth->validarLogin();

            //Si no hay un usuario
            if(empty($errores)) {
                //Comparamos columnas. Confirma si los datos estan almacenados o no.
                $usuario = Usuario::where('email', $auth->email);

               if($usuario) {
                //Verifica el password
                if($usuario->validarPassVerif($auth->password)) {
                    //Auth el usuario
                    session_start();

                    $_SESSION['id'] = $usuario->$id;
                    $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                    $_SESSION['email'] = $usuario->email;
                    $_SESSION['login'] = true;

                    //Redireccionamiento si es admin o cliente.
                    if($usuario->admin === 1) {

                        $_SESSION['admin'] = $usuario->admin ?? null;
                        header('Location: /admin');
                    } else {
                        header('Location: /cita');
                    }
                    debuguear($_SESSION);
                }

               } else {
                    Usuario::seterrores('error', 'Usuario no encontrado');
               }
            }
        }

        $errores = Usuario::geterrores();

        $router->render('auth/login' , [
            "errores" => $errores
        ]);
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

    public static function confirmar(Router $router) {

        $errores = [];

        $token = s($_GET['token']); //Llama al token que tenemos almacenado en la base de datos.

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            //Mostrar mensaje de eror.
            Usuario::seterrores('error', 'Token no valido');
        } else {
            //Modificar a usuario confirmado.
            $usuario->confirmado = '1';
            $usuario->token = '';
            $usuario->guardar();
            $usuario->seterrores('exito', 'Cuenta comprobada correctamente');
        }
        //Obtener alertas
        $errores = Usuario::geterrores();


        $router->render('auth/confirmar', [
            'errores' => $errores

        ]);
    }
}
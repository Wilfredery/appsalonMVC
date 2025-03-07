<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

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

                    $_SESSION['id'] = $usuario->id;
                    $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                    $_SESSION['email'] = $usuario->email;
                    $_SESSION['login'] = true;

                    //Redireccionamiento si es admin o cliente.
                    if($usuario->administrador === 1) {

                        $_SESSION['administrador'] = $usuario->administrador ?? null;
                        header('Location: /admin');
                    } else {
                        header('Location: /cita');
                    }
                    
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
        session_start();
        $_SESSION = []; //Guarda la info del usuario en un arreglo.
        header('Location: /');
    }

    //Esto se dedica a la validacion y confirmacion del ususario
    public static function olvidar(Router $router) {

        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);
            $errores = $auth->validarEmail();
            

            if(empty($errores)) {

                //Recordando que elwhere se enfoca en comparar valores de la db con la que se esta escribiendo.
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado === "1") {
                    //Generar un toquen para la contrase;a olvidada.

                    $usuario->crearToken();
                    $usuario->guardar();

                    //Eniar al email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInst();

                    //Alerta de exito
                    Usuario::seterrores('exito', 'Revisa tu email');   

                } else {
                    Usuario::seterrores('error', 'El usuario no existe o no esta confirmado');

                }
            }
        }
        
        $errores = Usuario::geterrores();

        $router->render('auth/olvidar', [
            'errores' => $errores
        ]);
    }

    public static function recuperar(Router $router) {
        
        $errores = [];

        //Variable para sacar al usuario del recuperar.php cuando el token no es valido/no esta almacenado en la base de datos.
        $noTokenValido = false;

        $token = s($_GET['token']);

        //Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::seterrores('error', 'Token no valido');
            $noTokenValido = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Leer el nuevo password y guardarlo.

            $password = new Usuario($_POST);
            $errores = $password->validarPassword();

            if(empty($errores)) {
                //El de abajo limpia el passsword hasheado anteriormente para guardar el nuevo.
                $usuario->password = null;
            
                //Agregando el nuevo passwoerd
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();

                if($resultado) {
                    header('Location: /');
                }
            }
        }

        $errores = Usuario::geterrores();

        $router->render('auth/recuperar', [
            'errores' => $errores,
            'noTokenValido' => $noTokenValido
        ]);
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
                    $resultado = $usuario->guardar();

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
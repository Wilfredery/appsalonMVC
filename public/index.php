<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\ApiControllers;
use Controllers\CitaControllers;
use Controllers\LoginControllers;
use MVC\Router;

$router = new Router();

//Iniciar sesion
$router->get('/', [LoginControllers::class, 'login']);
$router->post('/', [LoginControllers::class, 'login']);
$router->get('/logout', [LoginControllers::class, 'logout']);

//Recuperar contra
$router->get('/olvidar', [LoginControllers::class, 'olvidar']);
$router->post('/olvidar', [LoginControllers::class, 'olvidar']);
$router->get('/recuperar', [LoginControllers::class, 'recuperar']);
$router->post('/recuperar', [LoginControllers::class, 'recuperar']);

//Crearcuenta
$router->get('/crear', [LoginControllers::class, 'crear']);
$router->post('/crear', [LoginControllers::class, 'crear']);

//confirmar cuenta
$router->get('/confirmar', [LoginControllers::class, 'confirmar']);
$router->get('/mensaje',[LoginControllers::class, 'mensaje']);

//Area privada
$router->get('/cita', [CitaControllers::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

//API de citas
$router->get('/api/servicios', [ApiControllers::class, 'index']);
$router->post('/api/citas', [ApiControllers::class, 'guardar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
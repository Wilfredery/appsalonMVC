<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\ApiControllers;
use Controllers\CitaControllers;
use Controllers\LoginControllers;
use Controllers\ServicioController;
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
$router->post('/api/eliminar', [ApiControllers::class, 'eliminar']);

//CRUD de servicios del admin
$router->get('/servicios', [ServicioController::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->get('/servicios/eliminar', [ServicioController::class, 'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
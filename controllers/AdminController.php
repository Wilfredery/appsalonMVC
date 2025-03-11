<?php
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        isSession();

        $fecha = date('Y-m-d'); //manda el dia actual del sv.

        //Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS cliente, "; 
        $consulta .= " usuarios.email, usuarios.telefono,servicios.nombre as servicio, servicios.precio ";
        $consulta .= " FROM citas ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioid=usuarios.id ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.citaid=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ON ";
        $consulta .= " servicios.id=citasservicios.serviciosid";
        $consulta .= " WHERE fecha = $fecha ";

        $citas = AdminCita::SQL($consulta);
        //debuguear($citas);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}
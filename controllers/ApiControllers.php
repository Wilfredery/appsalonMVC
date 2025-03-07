<?php
namespace Controllers;

use Model\Cita;
use Model\CitasServicios;
use Model\Servicio;

class ApiControllers {
    public static function index() {
        $servicios = Servicio::all(); 
        echo json_encode($servicios);
    }

    public static function guardar() {
        //Almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado['id']; //Esto viene de la base de datos asi que no hay necesidad de escaparlo.


        //Almacena los servicios con el id de la cita
        $idServicios = explode(",", $_POST['servicios']); //Esto sirve para conv en arreglo y que separe con una coma(,) y el segundo parametro es cual quieres que se bregue
        
        foreach ($idServicios as $idservicio) {
            $args = [
                'citaid' => $id,
                'serviciosid' => $idservicio
            ];

            $citaServicio = new CitasServicios($args);
            $citaServicio->guardar();
        }

        //  Retorna una respuesta
        // $resultados = [
        //     'resultado' => $resultado
        // ];

        echo json_encode(['resultado' => $resultado]);
    }
}


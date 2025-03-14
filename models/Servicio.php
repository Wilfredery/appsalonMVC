<?php

namespace Model;

class Servicio extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args=[]) {

        $this->id = $args['id'] ?? null;
        $this->nombre = $argc['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';

    }

    public function validar() {
        if((!$this->nombre)) {
            self::$errores['error'][] = 'El nombre del servicio es obligatorio.';
        }

        if(!$this->precio) {
            self::$errores['error'][] = 'El precio del servicio es obligatorio.';
        }

        if(!is_numeric($this->precio)) {
            self::$errores['error'][] = 'El formato del precio no es valido.';
        }

        return self::$errores;
    }
}
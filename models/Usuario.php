<?php

namespace Model;

class Usuario extends ActiveRecord {
    //Base de datos

    protected static $tabla = 'usuarios';

    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'telefono', 'administrador', 'confirmado', 'token', 'password'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $administrador;
    public $confirmado;
    public $token;
    public $password;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->administrador = $args['administrador'] ?? null;
        $this->confirmado = $args['confirmado'] ?? null;
        $this->token = $args['token'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    //Mensajes de validacion para la creacion de una cuenta
    public function validarNewAcc() {


        if(!$this->nombre) {
            self::$errores['error'][] = 'El nombre del cliente es obligatorio.';
        }

        if(!$this->apellido) {
            self::$errores['error'][] = 'El apellido del cliente es obligatorio.';
        }

        if(!$this->email) {
            self::$errores['error'][] = 'El correo electronico del cliente es obligatorio.';
        }

        if(!$this->email) {
            self::$errores['error'][] = 'El email del cliente es obligatorio.';
        }

        if(!$this->telefono) {
            self::$errores['error'][] = 'El telefono del cliente es obligatorio.';
        }

        return self::$errores;
    }

}
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
        $this->administrador = $args['administrador'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    //Mensajes de validacion para la creacion de una cuenta
    public function validarNewAcc() {


        if(!$this->nombre) {
            self::$errores['error'][] = 'El nombre es obligatorio.';
        }

        if(!$this->apellido) {
            self::$errores['error'][] = 'El apellido es obligatorio.';
        }

        if(!$this->email) {
            self::$errores['error'][] = 'El correo electronico es obligatorio.';
        }

        if(!$this->password) {
            self::$errores['error'][] = 'El password es obligatorio.';
        }
        if(strlen($this->password) < 6) {
            self::$errores['error'][] = 'El password debe de contener al menos 6 caracteres de letras.';
        }

        if(!$this->telefono) {
            self::$errores['error'][] = 'El telefono es obligatorio.';
        }

        return self::$errores;
    }

    public function validarLogin() {
        if(!$this->email) {
            self::$errores['error'][] = 'El email es obligatorio.';
        }

        if(!$this->password) {
            self::$errores['error'][] = 'El password es obligatorio.';
        }

        return self::$errores;
    }

    //Revisa si el usuario ya existe.
    public function existeUsuario() {
        $query = "SELECT * FROM ".  self::$tabla . " WHERE email = '". $this->email. "' LIMIT 1";
        
        $resultado = self::$db->query($query);

        //Si ya existe el usuario. El num_rows confirma si hay o no hay datos almacenados.
        if($resultado->num_rows) {
            self::$errores['error'][] = 'Ya existe el usuario.';
        }
        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function validarPassVerif($password) {
        
        //Ayuda a validar el passowrd.
        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado) {
            self::$errores['error'][] = 'Password incorrecto o tu cuenta no esta confirmada.';
        } else {
            return true;
        }
    }
}
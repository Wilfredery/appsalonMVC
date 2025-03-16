<?php

use Dotenv\Dotenv;
use Model\ActiveRecord;

require __DIR__ . '/../vendor/autoload.php';


    $dotenv = Dotenv::createImmutable(__DIR__); // Usa createImmutable()
    $dotenv->load(); // Cargar las variables de entorno


require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);
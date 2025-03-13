<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//Funcion que revisa que el usuario este autenticado.
function isAuth() : void {
    //Recordando que el isset es si esta definida el valor.
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function isSession() : void {
    if(!isset($_SESSION)) {
        session_start();
    }
}

function esUltimo(string $actual, string $proximo): bool {
    //Si el valor actual es diferente al proximo significa que es el ultimo.

    if($actual != $proximo) { 
        return true;
    }

    return false;
}

function isAdmin() : void {
    if(!isset($_SESSION['administrador'])) {
        
        header('Location: /');
    }
}
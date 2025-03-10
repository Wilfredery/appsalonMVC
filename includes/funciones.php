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
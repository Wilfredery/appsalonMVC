let paso = 1;

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    tabs(); //Cambia la seccion cuando se presionen los tabs
}

function mostrarSeccion() {
    
    //Ocultar la seccion que tenga la clase de mostrar.
    const seccionAnterior = document.querySelector('.mostrar');

    if(seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }
    
    //Seleccionar la seccion con el paso...
    const pasoSelecc = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelecc);
    seccion.classList.add('mostrar');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function(event) {
            paso = parseInt(event.target.dataset.paso);

            mostrarSeccion();
        });
    });
}
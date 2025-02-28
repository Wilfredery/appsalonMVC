let paso = 1;

const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    tabs(); //Cambia la seccion cuando se presionen los tabs
    mostrarSeccion(); //Muestra y oculta las secciones
    botonesPag(); //Agrega o quita los botones del paginador.
    pagSiguiente();
    pagAnterior();

    consultarAPI(); //Consulta la API en el BackEnd de PHP
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

    // Quita la clase actual al tab anterior
    const tabAnt = document.querySelector('.actual');
    
    if(tabAnt) {
        tabAnt.classList.remove('actual');
    }

    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function(event) {
            paso = parseInt(event.target.dataset.paso);

            mostrarSeccion();
            botonesPag();
        });
    });
}

function botonesPag() {
    const pagAnt = document.querySelector('#anterior');
    const pagSig = document.querySelector('#siguiente');

    
    if(paso  === 1) {
        pagAnt.classList.add('ocultar');
        pagSig.classList.remove('ocultar');

    } else if (paso === 3) {
        pagAnt.classList.remove('ocultar');
        pagSig.classList.add('ocultar');

    } else {
        pagAnt.classList.remove('ocultar');
        pagSig.classList.remove('ocultar');
    }
    mostrarSeccion();
}

const pasoInit = 1;
const pasoFin = 3;
function pagAnterior() {
    const pagAnt = document.querySelector('#anterior');
    pagAnt.addEventListener('click' , function() {

        if(paso <= pasoInit) return;
        paso--;;
        
        botonesPag();
    })
}

function pagSiguiente() {
    const pagSig = document.querySelector('#siguiente');
    pagSig.addEventListener('click' , function() {

        if(paso >= pasoFin) return;
        paso++;;
        
        botonesPag();

    });

}

async function consultarAPI() {

    try {
        const url = 'http://localhost:3000/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarSev(servicios);
    } catch (error) {
        console.log(error);
    }
}
    
function mostrarSev(servicios) {
    servicios.forEach( servicio => {

        //Extraccion de valores.
        const {id, nombre, precio} = servicio;

        const nombreSev = document.createElement('P');
        nombreSev.classList.add('nombre-sev');
        nombreSev.textContent = nombre;

        const precioSev = document.createElement('P');
        precioSev.classList.add('precio-sev');
        precioSev.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        servicioDiv.onclick = function() {
            selecServ(servicio);
        }

        servicioDiv.appendChild(nombreSev);
        servicioDiv.appendChild(precioSev);

        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}

function selecServ(servicio) {
    const {id} = servicio;
    //Llama desde el objeto cita el arreglo de servicios[]
    const {servicios} = cita;
    //El triple punto es que hace una copia de ese arreglo de servicios y se le agrega al nuevo servicio.
    cita.servicios = [...servicios, servicio];

    const divServ = document.querySelector(`[data-id-servicio="${id}"]`);
    divServ.classList.add('seleccionado');
}
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

    nombreCliente(); //Añade el nombre del cliente al objeto de cita.
    selecFeha(); //Agrega la fecha en el objeto de cita.
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
    
    //Identificar el elemento al que se daclick.
    const divServ = document.querySelector(`[data-id-servicio="${id}"]`);

    //Comprobar si un servicio ya fue agregado o quitado
    if(servicios.some(agregado => agregado.id === id)) {
        //Si ya esta agregado, se elimina
        cita.servicios = servicios.filter( agregado => agregado.id !== id);
        divServ.classList.remove('seleccionado');

    } else {
        //Si no esta agregado, se agrega.

        //El triple punto es que hace una copia de ese arreglo de servicios y se le agrega al nuevo servicio.
        cita.servicios = [...servicios, servicio];
        divServ.classList.add('seleccionado');
    }
}

function nombreCliente() {
    //Lo que esta guardado en el input de nombre se guarda en el const nombre
    const nombre = document.querySelector('#nombre').value;
    //Del constnombre se guarda en este objeto.
    cita.nombre = nombre; 

}

function selecFeha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(evento) {

        //Permitiendo que esto vaya del domingo = 0 hasta el sabado = 6;
        const dia = new Date(evento.target.value).getUTCDay();
        
        //Siendo sabado 6 y domingo 0
        if( [6,0].includes(dia) ) {
            evento.target.value = '';
            //Sabado y domingo no abre.
           mostrarAlert('error', 'Fines de semana no es laborable.');
            
        } else {
            //Cita disponible de lunes a viernes.
            console.log('cita disponibles');
        }
    });
}

function mostrarAlert(tipo, mensaje) {

    //Si ya existe una alerta pues no permita que se haga mas alerta de la misma.
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) return;

    //Scripting para crear la alerta.
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const form = document.querySelector('.formulario');
    form.appendChild(alerta);

    //Duracion de la alerta mostrada
    setTimeout(() => {
        alerta.remove();
    }, 3000);
}

// Para los dias feriados, arreglarlo para este pasoInit
// function seleccionarFecha(){
    
//     const inputFecha = document.querySelector("#fecha");
//     inputFecha.addEventListener("input", function(e){
 
//         const dia = new Date(e.target.value).getUTCDay();
//         const diaFestivo = new Date(e.target.value).getUTCDate();
//         const mes = new Date(e.target.value).getUTCMonth() +1;
  
 
//         if([6,0].includes(dia)){
//             e.target.value= "";
//             mostrarAlerta("Fines de semana no permitido", "error", "#paso-2 p");
//         }else if((1 === diaFestivo & 1 === mes) ||
//                  ([4,5].includes(dia) & diaFestivo<10 & 4 === mes) ||
//                  (1 === diaFestivo & 5 === mes) ||
//                  ((7 === diaFestivo || 29 === diaFestivo) & 6 === mes) ||
//                  ((28 === diaFestivo || 29 === diaFestivo) & 7 === mes) ||
//                  ((6 === diaFestivo || 30 === diaFestivo) & 8 === mes) ||
//                  (8 === diaFestivo & 10 === mes) ||
//                  (1 === diaFestivo & 11 === mes) ||
//                  ((8 === diaFestivo || 9 === diaFestivo || 25 === diaFestivo) & 12 === mes)
         
//         ){
//             e.target.value= "";
//             mostrarAlerta("Feriados no hay atencion", "error", "#paso-2 p");
//         }
//         else{
//             cita.fecha = e.target.value;
//         }
//     })
// }
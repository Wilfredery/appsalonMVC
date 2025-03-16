let paso = 1;

const cita = {
    id: '',
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

    idClient(); 
    nombreCliente(); //Añade el nombre del cliente al objeto de cita.
    selecFecha(); //Agrega la fecha en el objeto de cita.
    SelecHora(); //Agregar la hora al objeto cita.

    mostrarResumen(); //Se mostrara el resumen de la cita.
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

        mostrarResumen();
        
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
        paso--;
        
        botonesPag();
    })
}

function pagSiguiente() {
    const pagSig = document.querySelector('#siguiente');
    pagSig.addEventListener('click' , function() {

        if(paso >= pasoFin) return;
        paso++;
        
        botonesPag();

    });

}

async function consultarAPI() {

    try {
        const url = `${Location.origin}/api/servicios`;
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

function idClient() {
    //Lo que esta guardado en el input de nombre se guarda en el const nombre
    const id = document.querySelector('#id').value;
    //Del constnombre se guarda en este objeto.
    cita.id = id; 
}


function nombreCliente() {
    //Lo que esta guardado en el input de nombre se guarda en el const nombre
    const nombre = document.querySelector('#nombre').value;
    //Del constnombre se guarda en este objeto.
    cita.nombre = nombre; 

}

function selecFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(evento) {

        //Permitiendo que esto vaya del domingo = 0 hasta el sabado = 6;
        const dia = new Date(evento.target.value).getUTCDay();
        
        //Siendo sabado 6 y domingo 0
        if( [6,0].includes(dia) ) {
            evento.target.value = '';
            //Sabado y domingo no abre.
           mostrarAlert('error', 'Fines de semana no es laborable.' , '.formulario');
            
        } else {
            cita.fecha = evento.target.value;
            //Cita disponible de lunes a viernes.
        }
    });
}

function SelecHora() {
    
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(evento) {
        
        //El evento.target.value te muestra en consola la hora que fue seleccionada
        const horaCita = evento.target.value;

        const hora = horaCita.split(":")[0]; //Split sirve para separar. MANDATORY> DOBEL COMILLAS 
        
        if(hora < 10 || hora > 18) {
            evento.target.value = '';
            mostrarAlert('error', "LA HORA SELECCIONADA NO ES VALIDA", '.formulario');

        } else {
            cita.hora = evento.target.value;
        }
    });
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    //Limpiar el contenido del resumen
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }


    //El Objwct.values() muestra si en el objeto esta vacio o tiene valores.
    //PARA VALIDAR UN OBJETO> OBJECT.VALUES()
    //PARA VALIDAR UN ARREGLO .LENGTH
    if(Object.values(cita).includes('') || cita.servicios.length === 0) {
        
        mostrarAlert('error', 'FALTA DATOS DE SERVICIO, FECHA U HORA', '.contenido-resumen', false);

        return;
    } 
    
    //Heading para servicios en resumen
    const headingServ = document.createElement('H3');
    headingServ.textContent = 'Resumen de servicios';
    resumen.appendChild(headingServ);

    //Iterando y mostrando en los servicios del resumen.
    cita.servicios.forEach(servicio => {

        const { id, precio, nombre } = servicio;

        const contenedorServ = document.createElement('DIV');
        contenedorServ.classList.add('contenedor-servicio');

        const textServ = document.createElement('P');
        textServ.textContent = nombre;

        const precioServ = document.createElement('P');
        precioServ.innerHTML = `<span>Precio: </span>$${precio}`;

        contenedorServ.append(textServ);
        contenedorServ.append(precioServ);

        resumen.appendChild(contenedorServ);
    });

    //Resumen de cita para servicios en resumen
     const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de cita';
    resumen.appendChild(headingCita);

    //Formatear el div de resumen
    const {nombre,fecha,hora, servicios} = cita;

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre: </span> ${nombre}`;

    //FORMATEAR LA FECHA EN SPANISH
    const fechaObj = new Date(fecha); //Recuerda al usar NEW DATE te resta 1 o 2 dias.
    const mes = fechaObj.getMonth();

    //Getdate dia del mes getday dia de la semana. +2 por utilizarlo 2 veces.
    const dia = fechaObj.getDate() + 2; 
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date( Date.UTC(year,mes,dia));
    //Palabra del dia de la semana, year numero y palabra del mes y dia numerico.
    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}; 
    const fecharFormat = fechaUTC.toLocaleDateString('es-ES', opciones); //Dia/mes/year
    
    
    const fechaCliente = document.createElement('P');
    fechaCliente.innerHTML = `<span>Fecha: </span> ${fecharFormat}`;

    const horaCliente = document.createElement('P');
    horaCliente.innerHTML = `<span>Hora: </span> ${hora}`;

    //Boton para crear una cita.
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCliente);
    resumen.appendChild(horaCliente);

    resumen.appendChild(botonReservar);
}

async function reservarCita() {

    const {id, fecha, hora, servicios} = cita;

    //Recuerda que el map itera cuando las coincidencia son iguales para almacenar.
    const idServicio = servicios.map(servicio => servicio.id);
    
    const datos = new FormData();
    
    //cON ESTO PERMITE ACCEDER CON LA VARIABLE POST
    datos.append('usuarioid', id);
    //datos.append('nombre', nombre);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('servicios', idServicio);

    // console.log([...datos]);

    try {
    //Peticion hacia la api
    const url =`${Location.origin}/api/citas`;
    const respuesta = await fetch(url, {
        method: 'POST',
        body: datos
    });

    const resultado = await respuesta.json();
    //console.log(resultado.resultado); devuelve true
        if(resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: "Cita creada",
                text: "Tu cita fue creada de manera exitosa.",
            }).then( () => {
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            });
        }
    }catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Hubo un error al guardar la cita. Por favor, intentarlo luego y disculpe por los inconvenientes.!",
        });
    }
}

function mostrarAlert(tipo, mensaje, elemento, desaparece = true) {
    //Si ya existe una alerta pues no permita que se haga mas alerta de la misma.
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alertaPrevia.remove();
    }

    //Scripting para crear la alerta.
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    //Si la vaina e true, desaparece y si es false se queda ahi
    if(desaparece) {
        //Duracion de la alerta mostrada
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
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
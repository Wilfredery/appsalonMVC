document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    buscarFecha();
}

function buscarFecha() {
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(e) {
        const fechaSeleccionar = e.target.value;
        console.log(fechaSeleccionar);

        //Para la fecha se vea en el input de fecha
        window.location = `?fecha=${fechaSeleccionar}`

    });
}
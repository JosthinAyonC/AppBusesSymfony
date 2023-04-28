function mostrarDatosTabla(datos) {
    let rolUsuarioLog = traerRol();
    var tablaReservas = document.getElementById("tablareserva");
    var tbody = tablaReservas.getElementsByTagName("tbody")[0];
    datos.forEach(function (reserva) {
        var fila = document.createElement("tr");
        fila.id = "reserva-" + reserva.idReserva;

        var celdaReserva = document.createElement("td");
        celdaReserva.textContent = reserva.idReserva;
        fila.appendChild(celdaReserva);

        var celdaPrecio = document.createElement("td");
        celdaPrecio.textContent = reserva.precio
        fila.appendChild(celdaPrecio);

        var celdaFecha = document.createElement("td");
        celdaFecha.textContent = reserva.fecha
        fila.appendChild(celdaFecha);

        var celdaEstado = document.createElement("td");
        celdaEstado.textContent = reserva.estado;
        fila.appendChild(celdaEstado);

        var celdaAcciones = document.createElement("td");

        if (rolUsuarioLog == "ROLE_ADMIN") {

            var botonBorrar = document.createElement('a');
            botonBorrar.classList.add('btn', 'btn-outline-primary', 'm-2', 'btn-borrar', 'btn-reserva');
            botonBorrar.id = 'btn-borrar';
            botonBorrar.textContent = 'Borrar';
            fila.appendChild(botonBorrar);

            var enlaceEditar = document.createElement('a');
            enlaceEditar.classList.add('btn', 'btn-outline-primary', 'm-2', 'btn-reserva', 'btn-editar');
            enlaceEditar.id = 'btn-editar'
            enlaceEditar.textContent = 'Editar';
            fila.appendChild(enlaceEditar);
            
            var vistazo = document.createElement('a');
            vistazo.classList.add('btn', 'btn-outline-primary', 'm-2', 'btn-reserva', 'btn-show');
            vistazo.id = 'btn-show'
            vistazo.textContent = 'Vistazo';
            fila.appendChild(vistazo);

            celdaAcciones.appendChild(vistazo);
            celdaAcciones.appendChild(botonBorrar);
            celdaAcciones.appendChild(enlaceEditar);

            fila.appendChild(celdaAcciones);

        }
        tbody.appendChild(fila);
    });
    
    let btn_reserva = document.querySelectorAll(".btn-reserva");

    btn_reserva.forEach(b => b.addEventListener("click", async (e) => {
        const botonActual = e.target;
        const idReserva = botonActual.parentNode.parentElement.children[0].innerText;
        const nombre = botonActual.parentNode.parentElement.children[1].innerText;

        if (botonActual.classList.contains("btn-borrar")) {

            let confirmacion = confirm(`Estas seguro que deseas eliminar la reserva ${nombre} ?`);

            if (confirmacion) {
                await fetch(`/reserva/${idReserva}/delete`, { method: 'PUT' })
                document.querySelector(`#reserva-${idReserva}`).remove()
                alert("Usuario borrado existosamente")

            }

        } else if (botonActual.classList.contains("btn-editar")) {

            window.location.replace(`/reserva/editar/${idReserva}`);
            
        }else{

            window.location.replace(`/reserva/visualizar/${idReserva}`);

        }
    }));
}

//METODO GET
async function ListarReservas() {
    try {
        const respuesta = await fetch('/reserva/get', { method: 'GET' });
        const datos = await respuesta.json();
        mostrarDatosTabla(datos);

    } catch (error) {
        console.log(error);
    }
}

// RENDERIZAR INDEX 
ListarReservas();

//OBTENER ROL DEL USUARIO LOGEADO
function traerRol() {
    let formRoles = document.getElementById("form-obtenerRoles");
    let formData = new FormData(formRoles);
    let data = Object.fromEntries(formData);

    return data.roles;
}
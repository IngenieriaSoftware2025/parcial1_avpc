import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormPrestamos = document.getElementById('FormPrestamos');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnTodos = document.getElementById('BtnTodos');
const BtnActivos = document.getElementById('BtnActivos');
const BtnDevueltos = document.getElementById('BtnDevueltos');
const selectLibros = document.getElementById('prestamo_libro_id');
const selectPersonas = document.getElementById('prestamo_persona_id');

let todosLosPrestamos = [];

const GuardarPrestamo = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormPrestamos, ['prestamo_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar todos los campos",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormPrestamos);
    const url = '/parcial1_avpc/prestamos/guardarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarPrestamos();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error)
    }
    BtnGuardar.disabled = false;
}

const BuscarPrestamos = async () => {
    const url = `/parcial1_avpc/prestamos/buscarAPI`;
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos

        if (codigo == 1) {
            todosLosPrestamos = data;
            datatable.clear().draw();
            datatable.rows.add(data).draw();
        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error)
    }
}

const CargarLibros = async () => {
    const url = `/parcial1_avpc/prestamos/obtenerLibrosAPI`;
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos

        if (codigo == 1) {
            selectLibros.innerHTML = '<option value="">Seleccione un libro</option>';
            data.forEach(libro => {
                selectLibros.innerHTML += `<option value="${libro.libro_id}">${libro.libro_titulo} - ${libro.libro_autor}</option>`;
            });
        }

    } catch (error) {
        console.log(error)
    }
}

const CargarPersonas = async () => {
    const url = `/parcial1_avpc/prestamos/obtenerPersonasAPI`;
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos

        if (codigo == 1) {
            selectPersonas.innerHTML = '<option value="">Seleccione una persona</option>';
            data.forEach(persona => {
                selectPersonas.innerHTML += `<option value="${persona.persona_id}">${persona.persona_nombre}</option>`;
            });
        }

    } catch (error) {
        console.log(error)
    }
}

const datatable = new DataTable('#TablePrestamos', {
    dom: `
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    columns: [
        {title: 'No.',data: 'prestamo_id',width: '5%',render: (data, type, row, meta) => meta.row + 1},
        {title: 'Libro', data: 'libro_titulo',width: '25%',render: (data, type, row) => {
         return `${row.libro_titulo}<br><small class="text-muted">Autor: ${row.libro_autor}</small>`;}},
        {title: 'Persona', data: 'persona_nombre',width: '20%'},
        { title: 'Fecha Préstamo', data: 'prestamo_fecha_prestamo',width: '15%'},
        { title: 'Fecha Devolución', data: 'prestamo_fecha_devolucion',width: '15%',render: (data, type, row) => {
        return data ? data : '<span class="text-muted">No devuelto</span>';}},
        {title: 'Estado',data: 'prestamo_devuelto',width: '10%',render: (data, type, row) => {
                if (data === 'S') {
                    return '<span class="badge bg-success">DEVUELTO</span>';
                } else {
                    return '<span class="badge bg-warning">ACTIVO</span>';
                }
            }
        },
        {
            title: 'Acciones',
            data: 'prestamo_id',
            searchable: false,
            orderable: false,
            width: '10%',
            render: (data, type, row, meta) => {
                let botones = '';
                
                if (row.prestamo_devuelto === 'N') {
                    botones += `
                        <button class='btn btn-success marcar-devuelto btn-sm mb-1' 
                            data-id="${data}"
                            title="Marcar como devuelto">
                            <i class='bi bi-check-circle'></i>
                        </button>`;
                }
                
                botones += `
                    <button class='btn btn-danger eliminar btn-sm mb-1' 
                        data-id="${data}"
                        title="Eliminar">
                        <i class="bi bi-trash3"></i>
                    </button>`;
                
                return `<div class='d-flex flex-column align-items-center'>${botones}</div>`;
            }
        }
    ]
});

const limpiarTodo = () => {
    FormPrestamos.reset();
}

const MarcarComoDevuelto = async (e) => {
    const idPrestamo = e.currentTarget.dataset.id

    const AlertaConfirmar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Marcar como devuelto?",
        text: 'Se registrará la fecha de devolución',
        showConfirmButton: true,
        confirmButtonText: 'Sí, marcar como devuelto',
        confirmButtonColor: '#28a745',
        cancelButtonText: 'Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmar.isConfirmed) {
        const body = new FormData();
        body.append('prestamo_id', idPrestamo);
        
        const url = `/parcial1_avpc/prestamos/marcarDevueltoAPI`;
        const config = {
            method: 'POST',
            body
        }

        try {
            const consulta = await fetch(url, config);
            const respuesta = await consulta.json();
            const { codigo, mensaje } = respuesta;

            if (codigo == 1) {
                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Éxito",
                    text: mensaje,
                    showConfirmButton: true,
                });
                
                BuscarPrestamos();
            } else {
                await Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                    showConfirmButton: true,
                });
            }

        } catch (error) {
            console.log(error)
        }
    }
}

const EliminarPrestamos = async (e) => {
    const idPrestamo = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Desea eliminar este préstamo?",
        text: 'Esta acción no se puede deshacer',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Eliminar',
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url =`/parcial1_avpc/prestamos/eliminar?id=${idPrestamo}`;
        const config = {
            method: 'GET'
        }

        try {
            const consulta = await fetch(url, config);
            const respuesta = await consulta.json();
            const { codigo, mensaje } = respuesta;

            if (codigo == 1) {
                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Éxito",
                    text: mensaje,
                    showConfirmButton: true,
                });
                
                BuscarPrestamos();
            } else {
                await Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                    showConfirmButton: true,
                });
            }

        } catch (error) {
            console.log(error)
        }
    }
}

const FiltrarTodos = () => {
    datatable.clear().draw();
    datatable.rows.add(todosLosPrestamos).draw();
}

const FiltrarActivos = () => {
    const activos = todosLosPrestamos.filter(prestamo => prestamo.prestamo_devuelto === 'N');
    datatable.clear().draw();
    datatable.rows.add(activos).draw();
}

const FiltrarDevueltos = () => {
    const devueltos = todosLosPrestamos.filter(prestamo => prestamo.prestamo_devuelto === 'S');
    datatable.clear().draw();
    datatable.rows.add(devueltos).draw();
}

CargarLibros();
CargarPersonas();
BuscarPrestamos();

datatable.on('click', '.marcar-devuelto', MarcarComoDevuelto);
datatable.on('click', '.eliminar', EliminarPrestamos);
FormPrestamos.addEventListener('submit', GuardarPrestamo);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnTodos.addEventListener('click', FiltrarTodos);
BtnActivos.addEventListener('click', FiltrarActivos);
BtnDevueltos.addEventListener('click', FiltrarDevueltos);
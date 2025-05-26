import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormPrestamos = document.getElementById('FormPrestamos');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const PrestamoPrecio = document.getElementById('prestamo_precio_libro');
const PrestamoStock = document.getElementById('prestamo_stock_libro');

const ValidarPrecio = () => {
    const precio = parseFloat(PrestamoPrecio.value);

    if (PrestamoPrecio.value.length < 1) {
        PrestamoPrecio.classList.remove('is-valid', 'is-invalid');
    } else {
        if (precio <= 0 || isNaN(precio)) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Precio inválido",
                text: "El precio debe ser mayor a 0",
                showConfirmButton: true,
            });

            PrestamoPrecio.classList.remove('is-valid');
            PrestamoPrecio.classList.add('is-invalid');
        } else {
            PrestamoPrecio.classList.remove('is-invalid');
            PrestamoPrecio.classList.add('is-valid');
        }
    }
}

const ValidarStock = () => {
    const stock = parseInt(PrestamoStock.value);

    if (PrestamoStock.value.length < 1) {
        PrestamoStock.classList.remove('is-valid', 'is-invalid');
    } else {
        if (stock < 0 || isNaN(stock)) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Stock inválido",
                text: "El stock no puede ser negativo",
                showConfirmButton: true,
            });

            PrestamoStock.classList.remove('is-valid');
            PrestamoStock.classList.add('is-invalid');
        } else {
            PrestamoStock.classList.remove('is-invalid');
            PrestamoStock.classList.add('is-valid');
        }
    }
}

const GuardarPrestamo = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormPrestamos, ['prestamo_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de validar todos los campos",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormPrestamos);

    const url = '/tienda/prestamos/guardarAPI';
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
                title: "Exito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarPrestamos();
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
    BtnGuardar.disabled = false;
}

const BuscarPrestamos = async () => {
    const url = `/tienda/prestamos/buscarAPI`;
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos

        if (codigo == 1) {
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
        {
            title: 'No.',
            data: 'prestamo_id',
            width: '%',
            render: (_data, _type, _row, meta) => meta.row + 1
        },
        { title: 'Libro', data: 'prestamo_nombre_libro' },
        { title: 'Descripción', data: 'prestamo_descripcion_libro' },
        { 
            title: 'Precio', 
            data: 'prestamo_precio_libro',
            render: (data) => {
                return `Q. ${parseFloat(data).toFixed(2)}`;
            }
        },
        { title: 'Stock', data: 'prestamo_stock_libro' },
        { title: 'ID Libro', data: 'libro_id' },
        {
            title: 'Acciones',
            data: 'prestamo_id',
            searchable: false,
            orderable: false,
            render: (data, _type, row) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-nombre="${row.prestamo_nombre_libro}"  
                         data-descripcion="${row.prestamo_descripcion_libro}"  
                         data-precio="${row.prestamo_precio_libro}"  
                         data-stock="${row.prestamo_stock_libro}"  
                         data-libro="${row.libro_id}">
                         <i class='bi bi-pencil-square me-1'></i> Modificar
                     </button>
                     <button class='btn btn-danger eliminar mx-1' 
                         data-id="${data}">
                        <i class="bi bi-trash3 me-1"></i>Eliminar
                     </button>
                 </div>`;
            }
        }
    ]
});

const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset

    document.getElementById('prestamo_id').value = datos.id
    document.getElementById('prestamo_nombre_libro').value = datos.nombre
    document.getElementById('prestamo_descripcion_libro').value = datos.descripcion
    document.getElementById('prestamo_precio_libro').value = datos.precio
    document.getElementById('prestamo_stock_libro').value = datos.stock
    document.getElementById('libro_id').value = datos.libro

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0,
    })
}

const limpiarTodo = () => {
    FormPrestamos.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarPrestamo = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormPrestamos, [''])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de validar todos los campos",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormPrestamos);

    const url = '/tienda/prestamos/modificarAPI';
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
                title: "Exito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarPrestamos();
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
    BtnModificar.disabled = false;
}

const EliminarPrestamos = async (e) => {
    const idPrestamo = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "info",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta completamente seguro que desea eliminar este registro',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: 'red',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url =`/tienda/prestamos/eliminar?id=${idPrestamo}`;
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
                    title: "Exito",
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

BuscarPrestamos();
datatable.on('click', '.eliminar', EliminarPrestamos);
datatable.on('click', '.modificar', llenarFormulario);
FormPrestamos.addEventListener('submit', GuardarPrestamo);
PrestamoPrecio.addEventListener('change', ValidarPrecio);
PrestamoStock.addEventListener('change', ValidarStock);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarPrestamo);

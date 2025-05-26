import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormPersonas = document.getElementById('FormPersonas');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const InputPersonaTelefono = document.getElementById('persona_telefono');
const PersonaNit = document.getElementById('persona_nit');
const FechaInicio = document.getElementById('fecha_inicio');
const FechaFin = document.getElementById('fecha_fin');
const BtnFiltrarFecha = document.getElementById('btn_filtrar_fecha');

const ValidarTelefono = () => {
    const CantidadDigitos = InputPersonaTelefono.value

    if (CantidadDigitos.length < 1) {
        InputPersonaTelefono.classList.remove('is-valid', 'is-invalid');
    } else {
        if (CantidadDigitos.length != 8) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Revise el número de teléfono",
                text: "La cantidad de dígitos debe ser igual a 8 dígitos",
                showConfirmButton: true,
            });

            InputPersonaTelefono.classList.remove('is-valid');
            InputPersonaTelefono.classList.add('is-invalid');
        } else {
            InputPersonaTelefono.classList.remove('is-invalid');
            InputPersonaTelefono.classList.add('is-valid');
        }
    }
}

function validarNit() {
    const nit = PersonaNit.value.trim();
    let nd, add = 0;

    if (nd = /^(\d+)-?([\dkK])$/.exec(nit)) {
        nd[2] = (nd[2].toLowerCase() === 'k') ? 10 : parseInt(nd[2], 10);

        for (let i = 0; i < nd[1].length; i++) {
            add += ((((i - nd[1].length) * -1) + 1) * parseInt(nd[1][i], 10));
        }
        return ((11 - (add % 11)) % 11) === nd[2];
    } else {
        return false;
    }
}

const EsValidoNit = () => {
    if (PersonaNit.value.trim() === '') {
        PersonaNit.classList.remove('is-valid', 'is-invalid');
        return;
    }

    if (validarNit()) {
        PersonaNit.classList.add('is-valid');
        PersonaNit.classList.remove('is-invalid');
    } else {
        PersonaNit.classList.remove('is-valid');
        PersonaNit.classList.add('is-invalid');

        Swal.fire({
            position: "center",
            icon: "error",
            title: "NIT INVÁLIDO",
            text: "El número de NIT ingresado es inválido",
            showConfirmButton: true,
        });
    }
}

const GuardarPersona = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormPersonas, ['persona_id'])) {
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

    const body = new FormData(FormPersonas);

    const url = '/parcial1_avpc/Personas/guardarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        console.log(datos)
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
            BuscarPersonas();
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

const BuscarPersonas = async () => {
    const fecha_inicio = FechaInicio?.value || '';
    const fecha_fin = FechaFin?.value || '';

    const params = new URLSearchParams();

    if (fecha_inicio) params.append('fecha_inicio', fecha_inicio);
    if (fecha_fin) params.append('fecha_fin', fecha_fin);

    const url = `/parcial1_avpc/Personas/buscarAPI?${params.toString()}`;
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

const datatable = new DataTable('#TablePersonas', {
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
            data: 'persona_id',
            width: '%',
            render: (_data, _type, _row, meta) => meta.row + 1
        },
        { title: 'Nombres', data: 'persona_nombres' },
        { title: 'Apellidos', data: 'persona_apellidos' },
        { title: 'Correo', data: 'persona_correo' },
        { title: 'Teléfono', data: 'persona_telefono' },
        { title: 'NIT', data: 'persona_nit' },
        { title: 'Dirección', data: 'persona_direccion' },
        { title: 'Fecha Registro', data: 'persona_fecha_registro'},
        {
            title: 'Acciones',
            data: 'persona_id',
            searchable: false,
            orderable: false,
            render: (data, _type, row, _meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-nombres="${row.persona_nombres}"  
                         data-apellidos="${row.persona_apellidos}"  
                         data-nit="${row.persona_nit}"  
                         data-telefono="${row.persona_telefono}"  
                         data-correo="${row.persona_correo}"  
                         data-direccion="${row.persona_direccion}" 
                         data-fecha="${row.persona_fecha_registro}">
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

    document.getElementById('persona_id').value = datos.id
    document.getElementById('persona_nombres').value = datos.nombres
    document.getElementById('persona_apellidos').value = datos.apellidos
    document.getElementById('persona_nit').value = datos.nit
    document.getElementById('persona_telefono').value = datos.telefono
    document.getElementById('persona_correo').value = datos.correo
    document.getElementById('persona_direccion').value = datos.direccion
    document.getElementById('persona_fecha_registro').value = datos.fecha

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0,
    })
}

const limpiarTodo = () => {
    FormPersonas.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarPersona = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormPersonas, [''])) {
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

    const body = new FormData(FormPersonas);

    const url = '/parcial1_avpc/personas/modificarAPI';
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
            BuscarPersonas();
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

const EliminarPersonas = async (e) => {
    const idpersona = e.currentTarget.dataset.id

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
        const url =`/parcial1_avpc/personas/eliminar?id=${idpersona}`;
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
                
                BuscarPersonas();
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

BuscarPersonas();
datatable.on('click', '.eliminar', EliminarPersonas);
datatable.on('click', '.modificar', llenarFormulario);
FormPersonas.addEventListener('submit', GuardarPersona);
PersonaNit.addEventListener('change', EsValidoNit);
InputPersonaTelefono.addEventListener('change', ValidarTelefono);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarPersona);
BtnFiltrarFecha.addEventListener('click', BuscarPersonas);
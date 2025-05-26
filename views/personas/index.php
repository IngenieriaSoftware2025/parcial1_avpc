<div class="container mt-4">
    <!-- Formulario de clientes -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-1">¡Bienvenido a la Aplicación para el registro, modificación y eliminación de clientes!</h5>
                    <h4 class="mb-0">MANIPULACIÓN DE CLIENTES</h4>
                </div>
                <div class="card-body">
                    <form id="FormClientes">
                        <input type="hidden" id="cliente_id" name="cliente_id">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cliente_nombres" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="cliente_nombres" name="cliente_nombres" placeholder="Ingrese los nombres" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cliente_apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="cliente_apellidos" name="cliente_apellidos" placeholder="Ingrese los apellidos" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cliente_nit" class="form-label">NIT</label>
                                <input type="text" class="form-control" id="cliente_nit" name="cliente_nit" placeholder="Ingrese el NIT" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cliente_telefono" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" id="cliente_telefono" name="cliente_telefono" placeholder="Ingrese el número de teléfono" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cliente_correo" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="cliente_correo" name="cliente_correo" placeholder="ejemplo@ejemplo.com" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cliente_direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="cliente_direccion" name="cliente_direccion" placeholder="Ingrese la dirección completa" required>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="cliente_fecha_registro" class="form-label">Fecha de Registro</label>
                                <input type="datetime-local" class="form-control" id="cliente_fecha_registro" name="cliente_fecha_registro" required>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button class="btn btn-success me-2" type="submit" id="BtnGuardar">
                                Guardar
                            </button>
                            <button class="btn btn-warning me-2 d-none" type="button" id="BtnModificar">
                                Modificar
                            </button>
                            <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de clientes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="text-center mb-0">Clientes registrados en la base de datos</h4>
                </div>
                <div class="card-body">
                    <!-- Filtro de fechas -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                            <input type="date" id="fecha_inicio" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="fecha_fin" class="form-label">Fecha de fin</label>
                            <input type="date" id="fecha_fin" class="form-control">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-primary w-100" id="btn_filtrar_fecha">
                                Buscar por fecha
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableClientes">
                            <!-- Aquí se cargan los clientes -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="<?= asset('build/js/clientes/index.js') ?>"></script>
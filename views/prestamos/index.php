<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-1">¡Sistema de Gestión de Préstamos!</h5>
                    <h4 class="mb-0">REGISTRO DE PRÉSTAMOS DE LIBROS</h4>
                </div>
                <div class="card-body">
                    <form id="FormPrestamos">
                        <input type="hidden" id="prestamo_id" name="prestamo_id">
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="prestamo_libro_id" class="form-label">Seleccionar Libro</label>
                                <select name="prestamo_libro_id" class="form-select" id="prestamo_libro_id" required>
                                    <option value="">Seleccione un libro</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="prestamo_persona_id" class="form-label">Seleccionar Persona</label>
                                <select name="prestamo_persona_id" class="form-select" id="prestamo_persona_id" required>
                                    <option value="">Seleccione una persona</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="prestamo_fecha_prestamo" class="form-label">Fecha de Préstamo</label>
                                <input type="datetime-local" class="form-control" id="prestamo_fecha_prestamo" name="prestamo_fecha_prestamo" required>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button class="btn btn-success me-2" type="submit" id="BtnGuardar">
                                <i class="bi bi-bookmark-plus me-1"></i>Registrar Préstamo
                            </button>
                            <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                <i class="bi bi-arrow-clockwise me-1"></i>Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="text-center mb-0">Filtrar Préstamos</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-info w-100" id="BtnTodos">
                                <i class="bi bi-list-ul me-1"></i>Todos los Préstamos
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-warning w-100" id="BtnActivos">
                                <i class="bi bi-clock me-1"></i>Préstamos Activos
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success w-100" id="BtnDevueltos">
                                <i class="bi bi-check-circle me-1"></i>Préstamos Devueltos
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="text-center mb-0">Préstamos registrados en el sistema</h4>
                </div>

                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TablePrestamos">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/prestamos/index.js') ?>"></script>
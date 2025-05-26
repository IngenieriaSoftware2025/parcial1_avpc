<div class="container mt-4">
    <!-- Formulario de Prestamos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark text-center">
                    <h5 class="mb-1">¡Bienvenido a la Aplicación para el registro, modificación y eliminación de Prestamos!</h5>
                    <h4 class="mb-0">MANIPULACIÓN DE Prestamos</h4>
                </div>
                <div class="card-body">
                    <form id="FormPrestamos">
                        <input type="hidden" id="prestamo_id" name="prestamo_id">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="prestamo_nombre_libro" class="form-label">nombre dle libro prestado</label>
                                <input type="text" class="form-control" id="prestamo_nombre_libro" name="prestamo_nombre_libro" placeholder="Ingrese el nombre del producto" required>
                            </div>
                            <div class="col-md-6">
                                <label for="prestamo_descripcion_libro" class="form-label">descripcion del libro prestado</label>
                                <input type="text" class="form-control" id="prestamo_descripcion_libro" name="prestamo_descripcion_libro" placeholder="Ingrese la descripción del producto" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="prestamo_precio_libro" class="form-label">precio del libro</label>
                                <input type="number" step="0.01" class="form-control" id="prestamo_precio_libro" name="prestamo_precio_libro" placeholder="0.00" required>
                            </div>
                            <div class="col-md-4">
                                <label for="prestamo_stock_libro" class="form-label">Libros Disponibles</label>
                                <input type="number" class="form-control" id="prestamo_stock_libro" name="prestamo_stock_libro" placeholder="0" required>
                            </div>
                            <div class="col-md-4">
                                <label for="libro_id" class="form-label">Marca</label>
                                <select name="libro_id" class="form-select" id="libro_id" required>
                                    <option value="">-- Seleccione una libro --</option>
                                    <?php foreach($marcas as $marca): ?>
                                        <option value="<?= $marca['libro_id'] ?>"><?= $marca['libro_titulo'] ?></option>
                                    <?php endforeach; ?>
                                </select>
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

    <!-- Tabla de Prestamos -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="text-center mb-0">Prestamos registrados en la base de datos</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TablePrestamos">
                            <!-- Aquí se cargan los Prestamos -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="<?= asset('build/js/prestamos/index.js') ?>"></script>
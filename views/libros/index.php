<div class="container mt-4">
    <!-- Formulario de Libros -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-1">¡Bienvenido a la Aplicación para el registro, modificación y eliminación de Libros!</h5>
                    <h4 class="mb-0">MANIPULACIÓN DE Libros</h4>
                </div>
                <div class="card-body">
                    <form id="FormLibros">
                        <input type="hidden" id="libro_id" name="libro_id">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="libro_titulo" class="form-label">Ingresa el nombre del libro</label>
                                <input type="text" class="form-control" id="libro_titulo" name="libro_titulo" required>
                            </div>
                            <div class="col-md-6">
                                <label for="libro_autor" class="form-label">Ingresa el Autor del libro</label>
                                <input type="text" class="form-control" id="libro_autor" name="libro_autor" required>
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


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="text-center mb-0">Libros registrados en la base de datos</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableLibros">
                            <!-- Aquí se cargan las Libros -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="<?= asset('build/js/libros/index.js') ?>"></script>
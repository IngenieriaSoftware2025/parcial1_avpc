<div class="container mt-4">
    <!-- Formulario de marcas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-1">¡Bienvenido a la Aplicación para el registro, modificación y eliminación de marcas!</h5>
                    <h4 class="mb-0">MANIPULACIÓN DE MARCAS</h4>
                </div>
                <div class="card-body">
                    <form id="FormMarcas">
                        <input type="hidden" id="marca_id" name="marca_id">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="marca_nombre" class="form-label">Nombre de la Marca</label>
                                <input type="text" class="form-control" id="marca_nombre" name="marca_nombre" placeholder="Ingrese el nombre de la marca" required>
                            </div>
                            <div class="col-md-6">
                                <label for="marca_descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="marca_descripcion" name="marca_descripcion" placeholder="Ingrese la descripción de la marca" required>
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

    <!-- Tabla de marcas -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="text-center mb-0">Marcas registradas en la base de datos</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableMarcas">
                            <!-- Aquí se cargan las marcas -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="<?= asset('build/js/marcas/index.js') ?>"></script>
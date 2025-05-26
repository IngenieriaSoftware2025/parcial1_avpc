<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-1">¡Sistema de Gestión de Libros!</h5>
                    <h4 class="mb-0">ADMINISTRACIÓN DE LIBROS</h4>
                </div>
                <div class="card-body">
                    <form id="FormLibros">
                        <input type="hidden" id="libro_id" name="libro_id">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="libro_titulo" class="form-label">Título del libro</label>
                                <input type="text" class="form-control" id="libro_titulo" name="libro_titulo" placeholder="Ingrese el título" required>
                            </div>
                            <div class="col-md-6">
                                <label for="libro_autor" class="form-label">Autor</label>
                                <input type="text" class="form-control" id="libro_autor" name="libro_autor" placeholder="Ingrese el autor" required>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button class="btn btn-success me-2" type="submit" id="BtnGuardar">
                                <i class="bi bi-floppy me-1"></i>Guardar
                            </button>
                            <button class="btn btn-warning me-2 d-none" type="button" id="BtnModificar">
                                <i class="bi bi-pencil-square me-1"></i>Modificar
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="text-center mb-0">Libros registrados en la biblioteca</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableLibros">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/libros/index.js') ?>"></script>
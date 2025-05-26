<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-1">¡Sistema de Gestión de Personas!</h5>
                    <h4 class="mb-0">ADMINISTRACIÓN DE PERSONAS</h4>
                </div>
                <div class="card-body">
                    <form id="FormPersonas">
                        <input type="hidden" id="persona_id" name="persona_id">
                        
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="persona_nombre" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="persona_nombre" name="persona_nombre" placeholder="Ingrese el nombre completo" required>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button class="btn btn-success me-2" type="submit" id="BtnGuardar">
                                    <i class="bi bi-person-plus me-1"></i>Agregar Persona
                                </button>
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Limpiar
                                </button>
                            </div>
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
                    <h4 class="text-center mb-0">Personas registradas en el sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TablePersonas">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/personas/index.js') ?>"></script>
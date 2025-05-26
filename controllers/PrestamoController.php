<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Prestamos;
use Model\Libros;
use Model\Personas;
use MVC\Router;

class PrestamoController extends ActiveRecord
{

    public function renderizarPagina(Router $router)
    {
        $router->render('prestamos/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        $libro_id = filter_var($_POST['prestamo_libro_id'], FILTER_SANITIZE_NUMBER_INT);
        $persona_id = filter_var($_POST['prestamo_persona_id'], FILTER_SANITIZE_NUMBER_INT);

        if (empty($libro_id) || $libro_id <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un libro válido'
            ]);
            return;
        }

        if (empty($persona_id) || $persona_id <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una persona válida'
            ]);
            return;
        }

        if (empty($_POST['prestamo_fecha_prestamo'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una fecha de préstamo'
            ]);
            return;
        }

        $_POST['prestamo_fecha_prestamo'] = date('Y-m-d H:i', strtotime($_POST['prestamo_fecha_prestamo']));

        try {
            $data = new Prestamos([
                'prestamo_libro_id' => $libro_id,
                'prestamo_persona_id' => $persona_id,
                'prestamo_fecha_prestamo' => $_POST['prestamo_fecha_prestamo'],
                'prestamo_devuelto' => 'N',
                'prestamo_situacion' => 1
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El préstamo ha sido registrado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            $data = self::obtenerPrestamosConDetalles();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Préstamos obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los préstamos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function marcarDevueltoAPI()
    {
        getHeadersApi();

        $id = filter_var($_POST['prestamo_id'], FILTER_SANITIZE_NUMBER_INT);

        try {
            $data = Prestamos::find($id);
            $fecha_devolucion = date('Y-m-d H:i');
            
            $data->sincronizar([
                'prestamo_devuelto' => 'S',
                'prestamo_fecha_devolucion' => $fecha_devolucion
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El préstamo ha sido marcado como devuelto'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al marcar como devuelto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function obtenerLibrosAPI()
    {
        try {
            $sql = "SELECT libro_id, libro_titulo, libro_autor FROM libros WHERE libro_situacion = 1";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Libros obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los libros',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function obtenerPersonasAPI()
    {
        try {
            $sql = "SELECT persona_id, persona_nombre FROM personas WHERE persona_situacion = 1";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Personas obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las personas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $ejecutar = Prestamos::EliminarPrestamos($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El préstamo ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}
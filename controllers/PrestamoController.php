<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Prestamos;
use Model\Libros;
use MVC\Router;

class PrestamoController extends ActiveRecord
{

    public function renderizarPagina(Router $router)
    {
        // Asegúrate de que el método ObtenerLibrosActivos exista en la clase Libros
        $libros = Libros::ObtenerLibrosActivos();
        $router->render('prestamos/index', [
            'libros' => $libros
        ]);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        $_POST['prestamo_libro_id'] = filter_var($_POST['prestamo_libro_id'], FILTER_VALIDATE_INT);
        $_POST['prestamo_usuario_id'] = filter_var($_POST['prestamo_usuario_id'], FILTER_VALIDATE_INT);
        $_POST['prestamo_fecha_inicio'] = date('Y-m-d H:i', strtotime($_POST['prestamo_fecha_inicio']));
        $_POST['prestamo_fecha_fin'] = date('Y-m-d H:i', strtotime($_POST['prestamo_fecha_fin']));

        if (!$_POST['prestamo_libro_id'] || $_POST['prestamo_libro_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un libro válido'
            ]);
            return;
        }

        if (!$_POST['prestamo_usuario_id'] || $_POST['prestamo_usuario_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un usuario válido'
            ]);
            return;
        }

        try {
            $data = new Prestamos([
                'prestamo_libro_id' => $_POST['prestamo_libro_id'],
                'prestamo_usuario_id' => $_POST['prestamo_usuario_id'],
                'prestamo_fecha_inicio' => $_POST['prestamo_fecha_inicio'],
                'prestamo_fecha_fin' => $_POST['prestamo_fecha_fin'],
                'prestamo_situacion' => 1
            ]);
            $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El préstamo ha sido registrado correctamente'
            ]);
            return;     
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar el préstamo',
                'detalle' => $e->getMessage(),
            ]);
        }   
    }

    public static function buscarAPI()
    {   
        try {
            $data = Prestamos::ObtenerPrestamosConLibrosYUsuarios();

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
    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['prestamo_id'];
        $_POST['prestamo_libro_id'] = filter_var($_POST['prestamo_libro_id'], FILTER_VALIDATE_INT);
        $_POST['prestamo_usuario_id'] = filter_var($_POST['prestamo_usuario_id'], FILTER_VALIDATE_INT);
        $_POST['prestamo_fecha_inicio'] = date('Y-m-d H:i', strtotime($_POST['prestamo_fecha_inicio']));
        $_POST['prestamo_fecha_fin'] = date('Y-m-d H:i', strtotime($_POST['prestamo_fecha_fin']));

        if (!$_POST['prestamo_libro_id'] || $_POST['prestamo_libro_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un libro válido'
            ]);
            return;
        }

        if (!$_POST['prestamo_usuario_id'] || $_POST['prestamo_usuario_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un usuario válido'
            ]);
            return;
        }

        try {
            $data = Prestamos::find($id);
            $data->sincronizar([
                'prestamo_libro_id' => $_POST['prestamo_libro_id'],
                'prestamo_usuario_id' => $_POST['prestamo_usuario_id'],
                'prestamo_fecha_inicio' => $_POST['prestamo_fecha_inicio'],
                'prestamo_fecha_fin' => $_POST['prestamo_fecha_fin'],
                'prestamo_situacion' => 1
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información del préstamo ha sido modificada exitosamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el préstamo',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    // Método duplicado y no relacionado con préstamos, eliminado para evitar conflictos y errores.
    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            Prestamos::EliminarPrestamo($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El préstamo ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar el préstamo',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
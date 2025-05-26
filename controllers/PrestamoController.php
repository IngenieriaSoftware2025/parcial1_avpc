<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Prestamos;
use Model\prestamos;
use MVC\Router;

class PrestamoController extends ActiveRecord
{

    public function renderizarPagina(Router $router)
    {
        $prestamos = Prestamos::ObtenerPrestamosActivas();
        $router->render('prestamos/index', [
            'prestamos' => $prestamos
        ]);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        $_POST['prestamo_nombre_libro'] = htmlspecialchars($_POST['prestamo_nombre_libro']);
        $cantidad_nombre = strlen($_POST['prestamo_nombre_libro']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del prestamos debe tener al menos 2 caracteres'
            ]);
            return;
        }

        $_POST['prestamo_descripcion_libro'] = htmlspecialchars($_POST['prestamo_descripcion_libro']);
        $_POST['prestamo_precio_libro'] = filter_var($_POST['prestamo_precio_libro'], FILTER_VALIDATE_FLOAT);
        $_POST['prestamo_stock_libro'] = filter_var($_POST['prestamo_stock_libro'], FILTER_VALIDATE_INT);
        $_POST['libro_id'] = filter_var($_POST['libro_id'], FILTER_VALIDATE_INT);

        if ($_POST['prestamo_precio_libro'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El precio debe ser mayor a 0'
            ]);
            return;
        }

        if ($_POST['prestamo_stock_libro'] < 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El stock no puede ser negativo'
            ]);
            return;
        }

        if (!$_POST['libro_id'] || $_POST['libro_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una prestamo válida'
            ]);
            return;
        }

        try {
            $data = new Libros([
                'prestamo_nombre_libro' => $_POST['prestamo_nombre_libro'],
                'prestamo_descripcion_libro' => $_POST['prestamo_descripcion_libro'],
                'prestamo_precio_libro' => $_POST['prestamo_precio_libro'],
                'prestamo_stock_libro' => $_POST['prestamo_stock_libro'],
                'libro_id' => $_POST['libro_id'],
                'prestamo_situacion' => 1
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El prestamos ha sido registrado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar el prestamos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            $data = Prestamos::ObtenerPrestamosConprestamo();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'prestamos obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los prestamos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['prestamo_id'];
        $_POST['prestamo_nombre_libro'] = htmlspecialchars($_POST['prestamo_nombre_libro']);

        $cantidad_nombre = strlen($_POST['prestamo_nombre_libro']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del prestamo debe tener al menos 2 caracteres'
            ]);
            return;
        }

        $_POST['prestamo_descripcion_libro'] = htmlspecialchars($_POST['prestamo_descripcion_libro']);
        $_POST['prestamo_precio_libro'] = filter_var($_POST['prestamo_precio_libro'], FILTER_VALIDATE_FLOAT);
        $_POST['prestamo_stock_libro'] = filter_var($_POST['prestamo_stock_libro'], FILTER_VALIDATE_INT);
        $_POST['libro_id'] = filter_var($_POST['libro_id'], FILTER_VALIDATE_INT);

        if ($_POST['prestamo_precio_libro'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El precio debe ser mayor a 0'
            ]);
            return;
        }

        if ($_POST['prestamo_stock_libro'] < 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El stock no puede ser negativo'
            ]);
            return;
        }

        if (!$_POST['libro_id'] || $_POST['libro_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una prestamo válida'
            ]);
            return;
        }

        try {
            $data = Prestamos::find($id);
            $data->sincronizar([
                'prestamo_nombre_libro' => $_POST['prestamo_nombre_libro'],
                'prestamo_descripcion_libro' => $_POST['prestamo_descripcion_libro'],
                'prestamo_precio_libro' => $_POST['prestamo_precio_libro'],
                'prestamo_stock_libro' => $_POST['prestamo_stock_libro'],
                'libro_id' => $_POST['libro_id'],
                'prestamo_situacion' => 1
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El prestamo ha sido modificado exitosamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el prestamo',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $ejecutar = Prestamos::EliminarPrestamo($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El prestamo ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar el prestamo',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}
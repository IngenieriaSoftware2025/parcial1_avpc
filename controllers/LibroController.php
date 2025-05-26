<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Libros;
use MVC\Router;

class LibroController extends ActiveRecord
{

    public function renderizarPagina(Router $router)
    {
        $router->render('libros/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        $_POST['libro_titulo'] = htmlspecialchars($_POST['libro_titulo']);
        $cantidad_nombre = strlen($_POST['libro_titulo']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre de la libro debe tener al menos 2 caracteres'
            ]);
            return;
        }

        $_POST['libro_autor'] = htmlspecialchars($_POST['libro_autor']);
        $_POST['libro_situacion'] = 1;

        try {
            $data = new Libros([
                'libro_titulo' => $_POST['libro_titulo'],
                'libro_autor' => $_POST['libro_autor'],
                'libro_situacion' => $_POST['libro_situacion']
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La marca ha sido registrada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar la marca',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            $condiciones = ["libro_situacion = 1"];
            $where = implode(" AND ", $condiciones);
            $sql = "SELECT * FROM marcas WHERE $where ORDER BY libro_titulo";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Marcas obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las marcas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['marca_id'];
        $_POST['libro_titulo'] = htmlspecialchars($_POST['libro_titulo']);

        $cantidad_nombre = strlen($_POST['libro_titulo']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre de la marca debe tener al menos 2 caracteres'
            ]);
            return;
        }

        $_POST['libro_autor'] = htmlspecialchars($_POST['libro_autor']);

        try {
            $data = Marcas::find($id);
            $data->sincronizar([
                'libro_titulo' => $_POST['libro_titulo'],
                'libro_autor' => $_POST['libro_autor'],
                'libro_situacion' => 1
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La marca ha sido modificada exitosamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la marca',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $ejecutar = Marcas::EliminarMarca($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La marca ha sido eliminada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar la marca',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}
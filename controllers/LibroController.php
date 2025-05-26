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

        $_POST['libro_titulo'] = htmlspecialchars(ucwords(strtolower(trim($_POST['libro_titulo']))));
        $cantidad_titulo = strlen($_POST['libro_titulo']);

        if ($cantidad_titulo < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El título debe tener al menos 2 caracteres'
            ]);
            return;
        }

        $_POST['libro_autor'] = htmlspecialchars(ucwords(strtolower(trim($_POST['libro_autor']))));
        $cantidad_autor = strlen($_POST['libro_autor']);

        if ($cantidad_autor < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El autor debe tener al menos 2 caracteres'
            ]);
            return;
        }

        try {
            $data = new Libros([
                'libro_titulo' => $_POST['libro_titulo'],
                'libro_autor' => $_POST['libro_autor'],
                'libro_situacion' => 1
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El libro ha sido registrado correctamente'
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
            $sql = "SELECT * FROM libros WHERE libro_situacion = 1";
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

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['libro_id'];
        $_POST['libro_titulo'] = htmlspecialchars(ucwords(strtolower(trim($_POST['libro_titulo']))));
        $cantidad_titulo = strlen($_POST['libro_titulo']);

        if ($cantidad_titulo < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El título debe tener al menos 2 caracteres'
            ]);
            return;
        }

        $_POST['libro_autor'] = htmlspecialchars(ucwords(strtolower(trim($_POST['libro_autor']))));
        $cantidad_autor = strlen($_POST['libro_autor']);

        if ($cantidad_autor < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El autor debe tener al menos 2 caracteres'
            ]);
            return;
        }

        try {
            $data = Libros::find($id);
            $data->sincronizar([
                'libro_titulo' => $_POST['libro_titulo'],
                'libro_autor' => $_POST['libro_autor'],
                'libro_situacion' => 1
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información del libro ha sido modificada exitosamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $ejecutar = Libros::EliminarLibros($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El libro ha sido eliminado correctamente'
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
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
                'mensaje' => 'El nombre del libro debe tener al menos 2 caracteres'
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
                'mensaje' => 'El libro ha sido registrado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar el libro',
                'detalle' => $e->getMessage(),
            ]);
        }
    }





    //BUASCAR BUSCAR
    public static function buscarAPI()
    {
        try {
            $condiciones = ["libro_situacion = 1"];
            $where = implode(" AND ", $condiciones);
            $sql = "SELECT * FROM libros WHERE $where ORDER BY libro_titulo";
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


    //MODIFICAR

      public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['libro_id'];
        $_POST['libro_titulo'] = htmlspecialchars($_POST['libro_titulo']);

        $cantidad_nombre = strlen($_POST['libro_titulo']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del libro debe tener al menos 2 caracteres'
            ]);
            return;
        }

        $_POST['libro_autor'] = htmlspecialchars($_POST['libro_autor']);

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
                'mensaje' => 'El libro ha sido modificado exitosamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el libro',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    //ELIMINAR

   public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $ejecutar = Libros::EliminarLibro($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El libro ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar el libro',
                'detalle' => $e->getMessage(),
            ]);
        }
    }


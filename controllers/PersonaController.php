<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Personas;
use MVC\Router;

class PersonaController extends ActiveRecord
{

    public function renderizarPagina(Router $router)
    {
        $router->render('personas/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        $_POST['persona_nombre'] = htmlspecialchars(ucwords(strtolower(trim($_POST['persona_nombre']))));
        $cantidad_nombre = strlen($_POST['persona_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre debe tener al menos 2 caracteres'
            ]);
            return;
        }

        try {
            $data = new Personas([
                'persona_nombre' => $_POST['persona_nombre'],
                'persona_situacion' => 1
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La persona ha sido registrada correctamente'
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
            $sql = "SELECT * FROM personas WHERE persona_situacion = 1";
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
            $ejecutar = Personas::EliminarPersonas($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La persona ha sido eliminada correctamente'
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
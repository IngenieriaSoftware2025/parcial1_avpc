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
        $router->render('Personas/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        $_POST['persona_nombres'] = htmlspecialchars($_POST['persona_nombres']);
        $cantidad_nombres = strlen($_POST['persona_nombres']);

        if ($cantidad_nombres < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de caracteres del nombre debe ser mayor a dos'
            ]);
            return;
        }

        $_POST['persona_apellidos'] = htmlspecialchars($_POST['persona_apellidos']);
        $cantidad_apellidos = strlen($_POST['persona_apellidos']);

        if ($cantidad_apellidos < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de caracteres del apellido debe ser mayor a dos'
            ]);
            return;
        }

        $_POST['persona_telefono'] = filter_var($_POST['persona_telefono'], FILTER_VALIDATE_INT);

        if (strlen($_POST['persona_telefono']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de dígitos de teléfono debe ser igual a 8'
            ]);
            return;
        }

        $_POST['persona_nit'] = htmlspecialchars($_POST['persona_nit']);
        $_POST['persona_correo'] = filter_var($_POST['persona_correo'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($_POST['persona_correo'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El correo electrónico ingresado es inválido'
            ]);
            return;
        }

        $_POST['persona_direccion'] = htmlspecialchars($_POST['persona_direccion']);
        $_POST['persona_fecha_registro'] = date('Y-m-d H:i', strtotime($_POST['persona_fecha_registro']));

        try {
            $data = new Personas([
                'persona_nombres' => $_POST['persona_nombres'],
                'persona_apellidos' => $_POST['persona_apellidos'],
                'persona_nit' => $_POST['persona_nit'],
                'persona_telefono' => $_POST['persona_telefono'],
                'persona_correo' => $_POST['persona_correo'],
                'persona_direccion' => $_POST['persona_direccion'],
                'persona_fecha_registro' => $_POST['persona_fecha_registro'],
                'persona_situacion' => 1
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El persona ha sido registrado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar el persona',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

            $condiciones = ["persona_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "persona_fecha_registro >= '{$fecha_inicio} 00:00'";
            }

            if ($fecha_fin) {
                $condiciones[] = "persona_fecha_registro <= '{$fecha_fin} 23:59'";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT * FROM personas WHERE $where ORDER BY persona_nombres, persona_apellidos";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'personas obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los personas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['persona_id'];
        $_POST['persona_nombres'] = htmlspecialchars($_POST['persona_nombres']);

        $cantidad_nombres = strlen($_POST['persona_nombres']);

        if ($cantidad_nombres < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de caracteres del nombre debe ser mayor a dos'
            ]);
            return;
        }

        $_POST['persona_apellidos'] = htmlspecialchars($_POST['persona_apellidos']);
        $cantidad_apellidos = strlen($_POST['persona_apellidos']);

        if ($cantidad_apellidos < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de caracteres del apellido debe ser mayor a dos'
            ]);
            return;
        }

        $_POST['persona_telefono'] = filter_var($_POST['persona_telefono'], FILTER_VALIDATE_INT);

        if (strlen($_POST['persona_telefono']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de dígitos de teléfono debe ser igual a 8'
            ]);
            return;
        }

        $_POST['persona_nit'] = htmlspecialchars($_POST['persona_nit']);
        $_POST['persona_correo'] = filter_var($_POST['persona_correo'], FILTER_SANITIZE_EMAIL);
        $_POST['persona_fecha_registro'] = date('Y-m-d H:i', strtotime($_POST['persona_fecha_registro']));

        if (!filter_var($_POST['persona_correo'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El correo electrónico ingresado es inválido'
            ]);
            return;
        }

        $_POST['persona_direccion'] = htmlspecialchars($_POST['persona_direccion']);

        try {
            $data = Personas::find($id);
            $data->sincronizar([
                'persona_nombres' => $_POST['persona_nombres'],
                'persona_apellidos' => $_POST['persona_apellidos'],
                'persona_nit' => $_POST['persona_nit'],
                'persona_telefono' => $_POST['persona_telefono'],
                'persona_correo' => $_POST['persona_correo'],
                'persona_direccion' => $_POST['persona_direccion'],
                'persona_fecha_registro' => $_POST['persona_fecha_registro'],
                'persona_situacion' => 1
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información del persona ha sido modificada exitosamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el persona',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $ejecutar = Personas::EliminarPersona($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El personas ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar el personas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}
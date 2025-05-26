<?php

namespace Model;

class Personas extends ActiveRecord {

    public static $tabla = 'personas';
    public static $columnasDB = [
        'persona_nombre',
        'persona_situacion'
    ];

    public static $idTabla = 'persona_id';
    public $persona_id;
    public $persona_nombre;
    public $persona_situacion;

    public function __construct($args = []){
        $this->persona_id = $args['persona_id'] ?? null;
        $this->persona_nombre = $args['persona_nombre'] ?? '';
        $this->persona_situacion = $args['persona_situacion'] ?? 1;
    }

    public static function EliminarPersonas($id){
        $sql = "DELETE FROM personas WHERE persona_id = $id";
        return self::SQL($sql);
    }

}
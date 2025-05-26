<?php

namespace Model;

class Peronas extends ActiveRecord {

    public static $tabla = 'personas';
    public static $columnasDB = [
        'persona_nombres',
        'persona_apellidos',
        'persona_nit',
        'persona_telefono',
        'persona_correo',
        'persona_direccion',
        'persona_fecha_registro',
        'persona_situacion'
    ];

    public static $idTabla = 'persona_id';
    public $persona_id;
    public $persona_nombres;
    public $persona_apellidos;
    public $persona_nit;
    public $persona_telefono;
    public $persona_correo;
    public $persona_direccion;
    public $persona_fecha_registro;
    public $persona_situacion;

    public function __construct($args = []){
        $this->persona_id = $args['persona_id'] ?? null;
        $this->persona_nombres = $args['persona_nombres'] ?? '';
        $this->persona_apellidos = $args['persona_apellidos'] ?? '';
        $this->persona_nit = $args['persona_nit'] ?? '';
        $this->persona_telefono = $args['persona_telefono'] ?? '';
        $this->persona_correo = $args['persona_correo'] ?? '';
        $this->persona_direccion = $args['persona_direccion'] ?? '';
        $this->persona_fecha_registro = $args['persona_fecha_registro'] ?? '';
        $this->persona_situacion = $args['persona_situacion'] ?? 1;
    }

    public static function EliminarCliente($id){
        $sql = "DELETE FROM personas WHERE persona_id = $id";
        return self::SQL($sql);
    }

    public static function ObtenerpersonasActivos(){
        $sql = "SELECT * FROM personas WHERE persona_situacion = 1 ORDER BY persona_nombres, persona_apellidos";
        return self::fetchArray($sql);
    }
}
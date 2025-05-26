<?php

namespace Model;

class Prestamos extends ActiveRecord {

    public static $tabla = 'prestamos';
    public static $columnasDB = [
        'prestamo_libro_id',
        'prestamo_persona_id',
        'prestamo_fecha_prestamo',
        'prestamo_devuelto',
        'prestamo_fecha_devolucion',
        'prestamo_situacion'
    ];

    public static $idTabla = 'prestamo_id';
    public $prestamo_id;
    public $prestamo_libro_id;
    public $prestamo_persona_id;
    public $prestamo_fecha_prestamo;
    public $prestamo_devuelto;
    public $prestamo_fecha_devolucion;
    public $prestamo_situacion;

    public function __construct($args = []){
        $this->prestamo_id = $args['prestamo_id'] ?? null;
        $this->prestamo_libro_id = $args['prestamo_libro_id'] ?? 0;
        $this->prestamo_persona_id = $args['prestamo_persona_id'] ?? 0;
        $this->prestamo_fecha_prestamo = $args['prestamo_fecha_prestamo'] ?? '';
        $this->prestamo_devuelto = $args['prestamo_devuelto'] ?? 'N';
        $this->prestamo_fecha_devolucion = $args['prestamo_fecha_devolucion'] ?? null;
        $this->prestamo_situacion = $args['prestamo_situacion'] ?? 1;
    }

    public static function EliminarPrestamos($id){
        $sql = "DELETE FROM prestamos WHERE prestamo_id = $id";
        return self::SQL($sql);
    }

}
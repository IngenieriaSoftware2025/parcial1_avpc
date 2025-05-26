<?php

namespace Model;

class Prestamos extends ActiveRecord {

    public static $tabla = 'prestamos';
    public static $columnasDB = [
        'prestamo_nombre_libro',
        'prestamo_descripcion_libro',
        'prestamo_precio_libro',
        'prestamo_stock_libro',
        'libro_id',
        'prestamo_situacion'
    ];

    public static $idTabla = 'producto_id';
    public $producto_id;
    public $prestamo_nombre_libro;
    public $prestamo_descripcion_libro;
    public $prestamo_precio_libro;
    public $prestamo_stock_libro;
    public $libro_id;
    public $prestamo_situacion;

    public function __construct($args = []){
        $this->producto_id = $args['producto_id'] ?? null;
        $this->prestamo_nombre_libro = $args['prestamo_nombre_libro'] ?? '';
        $this->prestamo_descripcion_libro = $args['prestamo_descripcion_libro'] ?? '';
        $this->prestamo_precio_libro = $args['prestamo_precio_libro'] ?? 0.00;
        $this->prestamo_stock_libro = $args['prestamo_stock_libro'] ?? 0;
        $this->libro_id = $args['libro_id'] ?? 0;
        $this->prestamo_situacion = $args['prestamo_situacion'] ?? 1;
    }

    public static function EliminarProducto($id){
        $sql = "DELETE FROM prestamos WHERE producto_id = $id";
        return self::SQL($sql);
    }

    public static function ObtenerprestamosConLibro(){
        $sql = "SELECT p.*, m.libro_nombre 
                FROM prestamos p 
                INNER JOIN libros m ON p.libro_id = m.libro_id 
                WHERE p.prestamo_situacion = 1 AND m.libro_situacion = 1
                ORDER BY p.prestamo_nombre_libro";
        return self::fetchArray($sql);
    }
}
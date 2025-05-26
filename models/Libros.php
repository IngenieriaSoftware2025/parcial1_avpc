<?php

namespace Model;

class Libros extends ActiveRecord {

    public static $tabla = 'libros';
    public static $columnasDB = [
        'libro_titulo',
        'libro_autor',
        'libro_situacion'
    ];

    public static $idTabla = 'libro_id';
    public $libro_id;
    public $libro_titulo;
    public $libro_autor;
    public $libro_situacion;

    public function __construct($args = []){
        $this->libro_id = $args['libro_id'] ?? null;
        $this->libro_titulo = $args['libro_titulo'] ?? '';
        $this->libro_autor = $args['libro_autor'] ?? '';
        $this->libro_situacion = $args['libro_situacion'] ?? 1;
    }

    public static function EliminarLibros($id){
        $sql = "DELETE FROM libros WHERE libro_id = $id";
        return self::SQL($sql);
    }

}
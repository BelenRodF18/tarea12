<?php
namespace App\Controllers;

use App\Models\ConcesionariaModel;

class EstadoController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function ver() {
        $respuesta = [
            'status' => 'ok',
            'message' => 'La API responde',
            'base_datos' => 'conectada (concesionaria)',
            'tablas' => []
        ];

        $modelo = new ConcesionariaModel($this->db);

        foreach (['Clientes', 'Vendedores', 'Autos', 'Ventas'] as $tabla) {
            $cantidad = $modelo->contar($tabla);
            $respuesta['tablas'][$tabla] = ($cantidad !== false)
                ? $cantidad
                : 'falta crear la tabla (phpMyAdmin o init.sql)';
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }
}

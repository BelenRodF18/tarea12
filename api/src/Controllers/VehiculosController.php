<?php
namespace App\Controllers;

use App\Models\ConcesionariaModel;

class VehiculosController {
    private $modelo;

    public function __construct($db) {
        $this->modelo = new ConcesionariaModel($db);
    }

    // GET /api/vehiculos  -> todos los autos con precio, nombre, marca y modelo
    public function listar() {
        echo json_encode(
            ['status' => 'ok', 'data' => $this->modelo->vehiculos()],
            JSON_UNESCAPED_UNICODE
        );
    }
}

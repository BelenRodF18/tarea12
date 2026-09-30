<?php
namespace App\Controllers;

use App\Models\ConcesionariaModel;

class VendedoresController {
    private $modelo;

    public function __construct($db) {
        $this->modelo = new ConcesionariaModel($db);
    }

    private function responder($data, $codigo = 200) {
        http_response_code($codigo);
        $estado = $codigo === 200 ? 'ok' : 'error';
        $clave  = $codigo === 200 ? 'data' : 'message';
        echo json_encode(['status' => $estado, $clave => $data], JSON_UNESCAPED_UNICODE);
    }

    // GET /api/vendedores  -> cantidad de ventas de cada vendedor
    public function listar() {
        $this->responder($this->modelo->ventasPorVendedor());
    }

    // GET /api/vendedores/:id  -> nombre del vendedor
    public function ver($id) {
        if (!ctype_digit($id)) {
            return $this->responder('El id debe ser un numero', 400);
        }
        $vendedor = $this->modelo->nombreVendedor((int) $id);
        if (!$vendedor) {
            return $this->responder('Vendedor no encontrado', 404);
        }
        $this->responder($vendedor);
    }

    // GET /api/vendedores/:id/ventas  -> que vendio, a quien, monto y fecha
    public function ventas($id) {
        if (!ctype_digit($id)) {
            return $this->responder('El id debe ser un numero', 400);
        }
        if (!$this->modelo->nombreVendedor((int) $id)) {
            return $this->responder('Vendedor no encontrado', 404);
        }
        $this->responder($this->modelo->ventasDeVendedor((int) $id));
    }
}

<?php
namespace App\Controllers;

use App\Models\ConcesionariaModel;

class ClientesController {
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

    // GET /api/clientes  -> reporte general (con o sin autos)
    public function reporte() {
        $this->responder($this->modelo->reporteClientes());
    }

    // GET /api/clientes/:id  -> solo el nombre completo
    public function ver($id) {
        if (!ctype_digit($id)) {
            return $this->responder('El id debe ser un numero', 400);
        }
        $cliente = $this->modelo->nombreCliente((int) $id);
        if (!$cliente) {
            return $this->responder('Cliente no encontrado', 404);
        }
        $this->responder($cliente);
    }

    // GET /api/clientes/:id/autos  -> historial de compras
    public function autos($id) {
        if (!ctype_digit($id)) {
            return $this->responder('El id debe ser un numero', 400);
        }
        if (!$this->modelo->nombreCliente((int) $id)) {
            return $this->responder('Cliente no encontrado', 404);
        }
        $this->responder($this->modelo->autosDeCliente((int) $id));
    }
}

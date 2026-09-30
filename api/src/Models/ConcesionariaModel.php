<?php
namespace App\Models;

class ConcesionariaModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // 1. Busqueda de cliente por ID: solo la columna del nombre completo.
    public function nombreCliente($id) {
        $stmt = $this->db->prepare(
            "SELECT Nombre_completo
             FROM Clientes
             WHERE ID_cliente = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // 2. Reporte general: todos los clientes, tengan o no autos (LEFT JOIN).
    public function reporteClientes() {
        $stmt = $this->db->query(
            "SELECT c.ID_cliente,
                    c.Nombre_completo,
                    a.Marca,
                    a.Modelo,
                    a.Matricula
             FROM Clientes c
             LEFT JOIN Ventas v ON c.ID_cliente = v.ID_cliente
             LEFT JOIN Autos  a ON v.ID_auto    = a.ID_auto
             ORDER BY c.ID_cliente, v.Fecha"
        );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // 3. Historial de compras: todos los autos de un cliente.
    public function autosDeCliente($id) {
        $stmt = $this->db->prepare(
            "SELECT c.Nombre_completo,
                    a.Marca,
                    a.Modelo
             FROM Ventas v
             INNER JOIN Clientes c ON v.ID_cliente = c.ID_cliente
             INNER JOIN Autos    a ON v.ID_auto    = a.ID_auto
             WHERE v.ID_cliente = ?
             ORDER BY v.Fecha"
        );
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // 4. Cantidad de autos vendidos por cada vendedor (los que tienen 0 tambien).
    public function ventasPorVendedor() {
        $stmt = $this->db->query(
            "SELECT ve.Nombre_completo,
                    COUNT(v.ID_venta) AS Cantidad_ventas
             FROM Vendedores ve
             LEFT JOIN Ventas v ON ve.ID_vendedor = v.ID_vendedor
             GROUP BY ve.ID_vendedor, ve.Nombre_completo
             ORDER BY Cantidad_ventas DESC, ve.Nombre_completo"
        );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Nombre de un vendedor (lo usa la pagina del front).
    public function nombreVendedor($id) {
        $stmt = $this->db->prepare(
            "SELECT Nombre_completo
             FROM Vendedores
             WHERE ID_vendedor = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // 5. Que vendio y a quien vendio un vendedor, con monto y fecha.
    public function ventasDeVendedor($id) {
        $stmt = $this->db->prepare(
            "SELECT a.Marca,
                    a.Modelo,
                    c.Nombre_completo AS Cliente,
                    v.Monto,
                    v.Fecha
             FROM Ventas v
             INNER JOIN Autos    a ON v.ID_auto    = a.ID_auto
             INNER JOIN Clientes c ON v.ID_cliente = c.ID_cliente
             WHERE v.ID_vendedor = ?
             ORDER BY v.Fecha"
        );
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // 7. Todos los vehiculos con su precio, marca, modelo y el nombre de quien lo compro.
    public function vehiculos() {
        $stmt = $this->db->query(
            "SELECT a.ID_auto,
                    c.Nombre_completo,
                    a.Marca,
                    a.Modelo,
                    a.Precio
             FROM Autos a
             LEFT JOIN Ventas   v ON a.ID_auto    = v.ID_auto
             LEFT JOIN Clientes c ON v.ID_cliente = c.ID_cliente
             ORDER BY a.ID_auto"
        );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function contar($tabla) {
        $permitidas = ['Clientes', 'Vendedores', 'Autos', 'Ventas'];
        if (!in_array($tabla, $permitidas, true)) {
            return false;
        }
        try {
            $stmt = $this->db->query("SELECT COUNT(*) AS total FROM $tabla");
            return (int) $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
        } catch (\Exception $e) {
            // Si la tabla todavia no existe
            return false;
        }
    }
}

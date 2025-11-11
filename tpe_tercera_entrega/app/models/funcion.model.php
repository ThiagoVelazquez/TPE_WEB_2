<?php 

class FuncionModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=tpe1;charset=utf8', 'root', '');
    }

    public function get($id) {
        $query = $this->db->prepare('SELECT * FROM funciones WHERE id = ? ');
        $query->execute([$id]);
        $funcion = $query->fetch(PDO::FETCH_OBJ);
        return $funcion;
    }

    public function getAll($sort = null, $order = 'asc', $limit = null, $offset = 0, $filterField = null, $filterValue = null) {
        $sql = 'SELECT * FROM funciones';
        $params = [];

        if ($filterField && $filterValue) {
            $allowedFilters = ['id_sala', 'nombre', 'duracion'];
            if (in_array($filterField, $allowedFilters)) {
                $sql .= " WHERE $filterField = ?";
                $params[] = $filterValue;
            }
        }

        if ($sort) {
            $allowedSorts = ['id', 'nombre', 'duracion', 'horarios', 'id_sala'];
            if (in_array($sort, $allowedSorts)) {
                $sql .= " ORDER BY $sort " . ($order === 'desc' ? 'DESC' : 'ASC'); 
            }
        }

        if ($limit) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }

        $query = $this->db->prepare($sql);
        $query->execute($params);
        $funciones = $query->fetchAll(PDO::FETCH_OBJ);
        return $funciones;
    }

    public function count($filterField = null, $filterValue = null) {
        $sql = 'SELECT COUNT(*) as total FROM funciones';
        $params = [];

        if ($filterField && $filterValue) {
            $allowedFilters = ['id_sala', 'nombre', 'duracion'];
            if (in_array($filterField, $allowedFilters)) {
                $sql .= " WHERE $filterField = ?";
                $params[] = $filterValue;
            }
        }

        $query = $this->db->prepare($sql);
        $query->execute($params);
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result->total;
    }

    function insert($nombre, $duracion, $horarios, $id_sala) {
        $query = $this->db->prepare("INSERT INTO funciones(nombre, duracion, horarios, id_sala) VALUES(?,?,?,?)");
        $query->execute([$nombre, $duracion, $horarios, $id_sala]);
        return $this->db->lastInsertId();
    }
    
    function remove($id) {
        $query = $this->db->prepare('DELETE from funciones where id = ?');
        $query->execute([$id]);
    }

    function update($id, $nombre, $duracion, $horarios, $id_sala) {
        $query = $this->db->prepare("
        UPDATE funciones
        SET nombre = ?, duracion = ?, horarios = ?, id_sala = ?
        WHERE id = ?
        ");
        $query->execute([$nombre, $duracion, $horarios, $id_sala, $id]);
    }
}
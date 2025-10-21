<?php
class FuncionModel {
    private $db;

    public function __construct() {
        $this->db = new PDO(
            "mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DB.";charset=utf8mb4", 
            MYSQL_USER, 
            MYSQL_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]
        );
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT f.*, s.codigo_sala, s.cantidad_max_personas, s.precio
                                  FROM funciones f
                                  LEFT JOIN salas s ON f.id_sala = s.id
                                  ORDER BY f.id DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT f.*, s.codigo_sala, s.cantidad_max_personas, s.precio
                                    FROM funciones f
                                    LEFT JOIN salas s ON f.id_sala = s.id
                                    WHERE f.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getBySalaId($id_sala) {
        $stmt = $this->db->prepare("SELECT f.*, s.codigo_sala, s.cantidad_max_personas, s.precio
                                    FROM funciones f
                                    LEFT JOIN salas s ON f.id_sala = s.id
                                    WHERE f.id_sala = ?
                                    ORDER BY f.id DESC");
        $stmt->execute([$id_sala]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO funciones (id_sala, nombre, duracion, horarios) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['id_sala'],
            $data['nombre'],
            $data['duracion'],
            $data['horarios']
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE funciones SET id_sala = ?, nombre = ?, duracion = ?, horarios = ? WHERE id = ?");
        return $stmt->execute([
            $data['id_sala'],
            $data['nombre'],
            $data['duracion'],
            $data['horarios'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM funciones WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

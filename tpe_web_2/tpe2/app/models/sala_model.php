<?php
class SalaModel {
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
        $stmt = $this->db->query("SELECT * FROM salas ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM salas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO salas (codigo_sala, cantidad_max_personas, precio) VALUES (?, ?, ?)");
        $stmt->execute([
            $data['codigo_sala'],
            $data['cantidad_max_personas'],
            $data['precio']
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE salas SET codigo_sala = ?, cantidad_max_personas = ?, precio = ? WHERE id = ?");
        return $stmt->execute([
            $data['codigo_sala'],
            $data['cantidad_max_personas'],
            $data['precio'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM salas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

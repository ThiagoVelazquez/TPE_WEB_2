<?php
class UserModel {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
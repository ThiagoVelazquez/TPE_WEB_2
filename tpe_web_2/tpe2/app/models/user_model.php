<?php
class UserModel {
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

    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

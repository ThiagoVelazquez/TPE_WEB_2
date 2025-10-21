<?php
const MYSQL_USER = 'root';
const MYSQL_PASS = '';
const MYSQL_DB = 'tpe1';
const MYSQL_HOST = '127.0.0.1';

class DatabaseModel {
    protected $db;

    public function __construct() {
        $this->db = new PDO(
            "mysql:host=".MYSQL_HOST.";charset=utf8mb4", 
            MYSQL_USER, 
            MYSQL_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]
        );
        $this->deploy();
    }

    private function deploy() {
        $query = $this->db->query("SHOW DATABASES LIKE '" . MYSQL_DB . "'");
        $exists = $query->fetch();

        if (!$exists) {
            $this->db->exec("CREATE DATABASE " . MYSQL_DB);
            $this->db->exec("USE " . MYSQL_DB);
            
            $sql = file_get_contents(__DIR__ . '/tpe1.sql');
            $this->db->exec($sql);
            
            $this->createDefaultUser();
        } else {
            $this->db->exec("USE " . MYSQL_DB);
            $this->checkAndCreateTables();
        }
    }

    private function checkAndCreateTables() {
        $query = $this->db->query("SHOW TABLES LIKE 'usuarios'");
        $tableExists = $query->fetch();

        if (!$tableExists) {
            $this->createUsersTable();
            $this->createDefaultUser();
        }
    }

    private function createUsersTable() {
        $create = "
            CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
                password CHAR(72) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        $this->db->exec($create);
    }

    private function createDefaultUser() {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ?");
        $query->execute(['webadmin']);
        
        if (!$query->fetch()) {
            $hash = password_hash('admin', PASSWORD_BCRYPT);
            $insert = $this->db->prepare("INSERT INTO usuarios (nombre_usuario, password) VALUES (?, ?)");
            $insert->execute(['webadmin', $hash]);
        }
    }

    public function getConnection() {
        return $this->db;
    }
}

try {
    $databaseModel = new DatabaseModel();
    $db = $databaseModel->getConnection();
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

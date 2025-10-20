<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'tpe1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('CHARSET', 'utf8mb4');

$dsn = "mysql:host=" . DB_HOST . ";charset=" . CHARSET;
$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $pdoOptions);

    $stmt = $pdo->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
    $exists = $stmt->fetch();

    if (!$exists) {
        $sqlFile = __DIR__ . '/tpe1.sql';
        if (!file_exists($sqlFile)) {
            throw new Exception("no se encontró tpe1.sql para crear la base de datos");
        }
        $sql = file_get_contents($sqlFile);
        $pdo->exec($sql);
    }

    $dsnDb = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . CHARSET;
    $db = new PDO($dsnDb, DB_USER, DB_PASS, $pdoOptions);

    $check = $db->query("SHOW TABLES LIKE 'usuarios'")->fetch();
    if (!$check) {
        $create = "
            CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
                password CHAR(72) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        $db->exec($create);
    }

    $q = $db->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ?");
    $q->execute(['webadmin']);
    if (!$q->fetch()) {
        $hash = password_hash('admin', PASSWORD_BCRYPT);
        $ins = $db->prepare("INSERT INTO usuarios (nombre_usuario, password) VALUES (?, ?)");
        $ins->execute(['webadmin', $hash]);
    }

} catch (PDOException $e) {
    die("error de conexión a la base de datos: " . $e->getMessage());
} catch (Exception $e) {
    die("error: " . $e->getMessage());
}
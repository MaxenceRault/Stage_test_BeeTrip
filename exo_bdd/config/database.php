<?php
class Database {
    private $host = "localhost";
    private $db_name = "gestion_projet_exo_stage";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }
        return $this->conn;
    }
}

$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "✅ Connexion réussie à MySQL !";
} else {
    echo "❌ Erreur de connexion.";
}

?>

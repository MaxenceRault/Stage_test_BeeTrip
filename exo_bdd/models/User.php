<?php
require_once dirname(__DIR__) . "/config/database.php";

class User {
    private $conn;
    private $table_name = "Utilisateur";

    public $id;
    public $nom;
    public $email;
    public $password;
    public $societe_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = "INSERT INTO " . $this->table_name . " (nom, email, password, societe_id) 
                  VALUES (:nom, :email, :password, :societe_id)";
        $stmt = $this->conn->prepare($query);

        // Hasher le mot de passe avant l'insertion
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":societe_id", $this->societe_id, PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($this->password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
}
?>

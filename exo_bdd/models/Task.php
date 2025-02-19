<?php
require_once dirname(__DIR__) . "/config/database.php";

class Task
{
    private $conn;
    private $table_name = "Tache";

    public $id;
    public $titre;
    public $description;
    public $date_deadline;
    public $etat;
    public $createur_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Créer une tâche
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (titre, description, dateDeadline, etat, createur_id) 
                  VALUES (:titre, :description, :dateDeadline, 'en attente', :createur_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titre", $this->titre);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":dateDeadline", $this->date_deadline);
        $stmt->bindParam(":createur_id", $this->createur_id);

        return $stmt->execute();
    }

    // Récupérer toutes les tâches d'un utilisateur
    public function getAllTasksByUser($userId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE createur_id = :userId ORDER BY dateDeadline ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une tâche spécifique
    public function getTaskById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour une tâche
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET titre = :titre, description = :description, dateDeadline = :dateDeadline, etat = :etat
                  WHERE id = :id AND createur_id = :createur_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":titre", $this->titre);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":dateDeadline", $this->date_deadline);
        $stmt->bindParam(":etat", $this->etat);
        $stmt->bindParam(":createur_id", $this->createur_id);

        return $stmt->execute();
    }

    // Supprimer une tâche
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id AND createur_id = :createur_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":createur_id", $this->createur_id);

        return $stmt->execute();
    }

    public function assignUser($userId, $role)
    {
        $query = "INSERT INTO Affectation (tache_id, utilisateur_id, role) VALUES (:tache_id, :utilisateur_id, :role)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tache_id", $this->id);
        $stmt->bindParam(":utilisateur_id", $userId);
        $stmt->bindParam(":role", $role);

        return $stmt->execute();
    }

    // Récupérer les utilisateurs assignés à une tâche
    public function getAssignedUsers()
    {
        $query = "SELECT Utilisateur.nom, Affectation.role 
                  FROM Affectation 
                  JOIN Utilisateur ON Affectation.utilisateur_id = Utilisateur.id 
                  WHERE Affectation.tache_id = :tache_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tache_id", $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un commentaire à une tâche
    public function addComment($userId, $texte)
    {
        $query = "INSERT INTO Commentaire (texte, utilisateur_id, tache_id) VALUES (:texte, :utilisateur_id, :tache_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":texte", $texte);
        $stmt->bindParam(":utilisateur_id", $userId);
        $stmt->bindParam(":tache_id", $this->id);

        return $stmt->execute();
    }

    // Récupérer les commentaires d'une tâche
    public function getComments()
    {
        $query = "SELECT Commentaire.texte, Commentaire.dateCreation, Utilisateur.nom 
              FROM Commentaire 
              JOIN Utilisateur ON Commentaire.utilisateur_id = Utilisateur.id 
              WHERE Commentaire.tache_id = :tache_id 
              ORDER BY Commentaire.dateCreation ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tache_id", $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lier une tâche à une autre
    public function linkTask($referenceId)
    {
        $query = "INSERT INTO TacheLiee (tache_id, tache_reference_id) VALUES (:tache_id, :tache_reference_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tache_id", $this->id);
        $stmt->bindParam(":tache_reference_id", $referenceId);

        return $stmt->execute();
    }

    // Récupérer les tâches liées à une tâche
    public function getLinkedTasks()
    {
        $query = "SELECT Tache.id, Tache.titre 
              FROM TacheLiee 
              JOIN Tache ON TacheLiee.tache_reference_id = Tache.id 
              WHERE TacheLiee.tache_id = :tache_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tache_id", $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Récupérer toutes les tâches avec le nom du créateur
    public function getAllTasks()
    {
        $query = "SELECT Tache.*, Utilisateur.nom AS createur_nom 
              FROM Tache 
              JOIN Utilisateur ON Tache.createur_id = Utilisateur.id 
              ORDER BY Tache.dateDeadline ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}
?>
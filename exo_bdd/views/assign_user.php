<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    echo "❌ Aucune tâche spécifiée.";
    exit();
}

require_once "../config/database.php";
require_once "../models/Task.php";

$database = new Database();
$db = $database->getConnection();
$task = new Task($db);
$task->id = $_GET["id"];

?>

<h2>Assigner un utilisateur à la tâche</h2>
<form action="../controllers/TaskController.php" method="POST">
    <input type="hidden" name="tache_id" value="<?php echo $task->id; ?>">
    
    <label for="utilisateur_id">Sélectionner un utilisateur :</label>
    <select name="utilisateur_id" required>
        <?php
        $stmt = $db->query("SELECT id, nom FROM Utilisateur");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$row['id']}'>{$row['nom']}</option>";
        }
        ?>
    </select>

    <label for="role">Rôle :</label>
    <select name="role" required>
        <option value="Responsable">Responsable</option>
        <option value="Relecteur">Relecteur</option>
        <option value="Suiveur">Suiveur</option>
    </select>

    <button type="submit" name="assign_user">Assigner</button>
</form>
<a href="dashboard.php">Retour</a>

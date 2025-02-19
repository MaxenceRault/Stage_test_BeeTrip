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

$tache = $task->getTaskById($_GET["id"]);

if (!$tache || $tache["createur_id"] != $_SESSION["user_id"]) {
    echo "❌ Vous n'avez pas la permission de modifier cette tâche.";
    exit();
}
?>
<link rel="stylesheet" href="../styles.css">
<div class="container">
    <h2>Modifier la tâche</h2>
    <form action="../controllers/TaskController.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $tache['id']; ?>">
        <input type="text" name="titre" value="<?php echo htmlspecialchars($tache['titre']); ?>" required>
        <textarea name="description"><?php echo htmlspecialchars($tache['description']); ?></textarea>
        <label for="date_deadline">Date limite :</label>
        <input type="date" name="date_deadline" value="<?php echo $tache['dateDeadline']; ?>" required>
        <label for="etat">Statut :</label>
        <select name="etat">
            <option value="en attente" <?php echo ($tache['etat'] == 'en attente') ? 'selected' : ''; ?>>En attente
            </option>
            <option value="complétée" <?php echo ($tache['etat'] == 'complétée') ? 'selected' : ''; ?>>Complétée</option>
        </select>
        <button type="submit" name="update_task">Modifier</button>
    </form>
    <a href="dashboard.php">Annuler</a>
</div>
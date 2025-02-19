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
<link rel="stylesheet" href="../styles.css">
<div class="container">
    <h2>Ajouter un commentaire</h2>
    <form action="../controllers/TaskController.php" method="POST">
        <input type="hidden" name="tache_id" value="<?php echo $task->id; ?>">

        <textarea name="texte" placeholder="Écrire un commentaire..." required></textarea>
        <button type="submit" name="add_comment">Commenter</button>
    </form>
    <a href="dashboard.php">Retour</a>
</div>
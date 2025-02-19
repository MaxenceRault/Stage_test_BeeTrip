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
    <h2>Lier une tâche</h2>
    <form action="../controllers/TaskController.php" method="POST">
        <input type="hidden" name="tache_id" value="<?php echo $task->id; ?>">

        <label for="tache_reference_id">Sélectionner une tâche à lier :</label>
        <select name="tache_reference_id" required>
            <?php
            $stmt = $db->query("SELECT id, titre FROM Tache WHERE id != " . $task->id);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id']}'>{$row['titre']}</option>";
            }
            ?>
        </select>

        <button type="submit" name="link_task">Lier</button>
    </form>
    <a href="dashboard.php">Retour</a>
</div>
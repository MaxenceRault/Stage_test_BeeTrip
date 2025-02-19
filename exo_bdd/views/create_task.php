<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>
<link rel="stylesheet" href="../styles.css">
<div class="container">
    <h2>Créer une tâche</h2>
    <form action="../controllers/TaskController.php" method="POST">
        <input type="text" name="titre" placeholder="Titre de la tâche" required>
        <textarea name="description" placeholder="Description"></textarea>
        <label for="date_deadline">Date limite :</label>
        <input type="date" name="date_deadline" required>
        <button type="submit" name="create_task">Créer la tâche</button>
    </form>
    <a href="dashboard.php">Retour au tableau de bord</a>
</div>
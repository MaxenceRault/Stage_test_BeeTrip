<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once "../config/database.php";
require_once "../models/Task.php";

$database = new Database();
$db = $database->getConnection();
$taskObj = new Task($db);

// Récupérer les tâches de l'utilisateur connecté
$taches = $taskObj->getAllTasksByUser($_SESSION["user_id"]);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>

    <div class="container">
        <h1>Bienvenue, <?php echo $_SESSION["nom"]; ?> !</h1>
        <a href="create_task.php">Créer une nouvelle tâche</a>
        <a href="../controllers/LogoutController.php">Déconnexion</a>

        <h2>Vos tâches :</h2>

        <?php if (empty($taches)): ?>
            <p>Vous n'avez aucune tâche.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($taches as $tache):
                    $taskObj->id = $tache["id"];
                    $assignedUsers = $taskObj->getAssignedUsers();
                    $comments = $taskObj->getComments();
                    $linkedTasks = $taskObj->getLinkedTasks();
                    ?>
                    <li>
                        <strong><?php echo htmlspecialchars($tache["titre"]); ?></strong>
                        <p><?php echo htmlspecialchars($tache["description"]); ?></p>
                        <p>Échéance : <?php echo $tache["dateDeadline"]; ?></p>
                        <p>Statut : <?php echo $tache["etat"]; ?></p>

                        <p><strong>Utilisateurs assignés :</strong></p>
                        <ul>
                            <?php if (empty($assignedUsers)): ?>
                                <li>Aucun utilisateur assigné.</li>
                            <?php else: ?>
                                <?php foreach ($assignedUsers as $user): ?>
                                    <li><?php echo htmlspecialchars($user["nom"]) . " - " . htmlspecialchars($user["role"]); ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>

                        <p><strong>Commentaires :</strong></p>
                        <ul>
                            <?php if (empty($comments)): ?>
                                <li>Aucun commentaire.</li>
                            <?php else: ?>
                                <?php foreach ($comments as $comment): ?>
                                    <li>
                                        <strong><?php echo htmlspecialchars($comment["nom"]); ?></strong>
                                        (<?php echo $comment["dateCreation"]; ?>) :
                                        <?php echo htmlspecialchars($comment["texte"]); ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>

                        <p><strong>Tâches liées :</strong></p>
                        <ul>
                            <?php if (empty($linkedTasks)): ?>
                                <li>Aucune tâche liée.</li>
                            <?php else: ?>
                                <?php foreach ($linkedTasks as $linkedTask): ?>
                                    <li><?php echo htmlspecialchars($linkedTask["titre"]); ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>

                        <a href="edit_task.php?id=<?php echo $tache["id"]; ?>">Modifier</a>
                        <a href="../controllers/TaskController.php?delete_task=<?php echo $tache["id"]; ?>"
                            onclick="return confirm('Voulez-vous vraiment supprimer cette tâche ?');">
                            Supprimer
                        </a>
                        <a href="assign_user.php?id=<?php echo $tache["id"]; ?>">Assigner un utilisateur</a>
                        <a href="comment_task.php?id=<?php echo $tache["id"]; ?>">Commenter</a>
                        <a href="link_task.php?id=<?php echo $tache["id"]; ?>">Lier une tâche</a>
                        <a href="../index.php">Retourner a l'accueil</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

</body>

</html>
<?php
session_start();
require_once "config/database.php";
require_once "models/Task.php";

$database = new Database();
$db = $database->getConnection();
$taskObj = new Task($db);

// Récupérer toutes les tâches
$toutesTaches = $taskObj->getAllTasks();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des tâches</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="container">
        <h1>Liste de toutes les tâches</h1>

        <?php if (isset($_SESSION["user_id"])): ?>
            <p>Connecté en tant que <strong><?php echo $_SESSION["nom"]; ?></strong></p>
            <a href="views/dashboard.php">Tableau de bord</a>
            <a href="controllers/LogoutController.php">Déconnexion</a>
        <?php else: ?>
            <a href="views/login.php">Se connecter</a>
            <a href="views/register.php">Créer un compte</a>
        <?php endif; ?>

        <h2>Toutes les tâches :</h2>

        <?php if (empty($toutesTaches)): ?>
            <p>Aucune tâche n'a été créée.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($toutesTaches as $tache):
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
                        <p>Créé par : <?php echo htmlspecialchars($tache["createur_nom"]); ?></p>

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

                        <?php if (isset($_SESSION["user_id"])): ?>
                            <a href="views/comment_task.php?id=<?php echo $tache["id"]; ?>">Commenter</a>
                            <a href="views/link_task.php?id=<?php echo $tache["id"]; ?>">Lier une tâche</a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

</body>

</html>
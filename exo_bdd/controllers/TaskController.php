<?php
session_start();
require_once dirname(__DIR__) . "/config/database.php";
require_once dirname(__DIR__) . "/models/Task.php";

$database = new Database();
$db = $database->getConnection();
$task = new Task($db);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_task"])) {
    if (!isset($_SESSION["user_id"])) {
        echo "❌ Vous devez être connecté pour créer une tâche.";
        exit();
    }

    $task->titre = trim($_POST["titre"]);
    $task->description = trim($_POST["description"]);
    $task->date_deadline = $_POST["date_deadline"];
    $task->createur_id = $_SESSION["user_id"];

    if ($task->create()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "❌ Erreur lors de la création de la tâche.";
    }
}

// Modification d'une tâche
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_task"])) {
    if (!isset($_SESSION["user_id"])) {
        echo "❌ Vous devez être connecté pour modifier une tâche.";
        exit();
    }

    $task->id = $_POST["id"];
    $task->titre = trim($_POST["titre"]);
    $task->description = trim($_POST["description"]);
    $task->date_deadline = $_POST["date_deadline"];
    $task->etat = $_POST["etat"];
    $task->createur_id = $_SESSION["user_id"];

    if ($task->update()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "❌ Erreur lors de la modification de la tâche.";
    }
}

// Suppression d'une tâche
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_task"])) {
    if (!isset($_SESSION["user_id"])) {
        echo "❌ Vous devez être connecté pour supprimer une tâche.";
        exit();
    }

    $task->id = $_GET["delete_task"];
    $task->createur_id = $_SESSION["user_id"];

    if ($task->delete()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "❌ Erreur lors de la suppression de la tâche.";
    }
}

// Assigner un utilisateur à une tâche
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["assign_user"])) {
    if (!isset($_SESSION["user_id"])) {
        echo "❌ Vous devez être connecté pour assigner un utilisateur.";
        exit();
    }

    $task->id = $_POST["tache_id"];
    $userId = $_POST["utilisateur_id"];
    $role = $_POST["role"];

    if ($task->assignUser($userId, $role)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "❌ Erreur lors de l'assignation.";
    }
}
// Ajouter un commentaire
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_comment"])) {
    if (!isset($_SESSION["user_id"])) {
        echo "❌ Vous devez être connecté pour commenter.";
        exit();
    }

    $task->id = $_POST["tache_id"];
    $texte = trim($_POST["texte"]);
    $userId = $_SESSION["user_id"];

    if ($task->addComment($userId, $texte)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "❌ Erreur lors de l'ajout du commentaire.";
    }
}

// Lier une tâche à une autre
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["link_task"])) {
    if (!isset($_SESSION["user_id"])) {
        echo "❌ Vous devez être connecté pour lier une tâche.";
        exit();
    }

    $task->id = $_POST["tache_id"];
    $referenceId = $_POST["tache_reference_id"];

    if ($task->linkTask($referenceId)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "❌ Erreur lors de l'ajout du lien entre les tâches.";
    }
}
?>
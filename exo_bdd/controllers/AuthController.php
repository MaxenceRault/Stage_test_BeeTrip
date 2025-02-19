<?php
session_start();
require_once dirname(__DIR__) . "/config/database.php";
require_once dirname(__DIR__) . "/models/User.php";

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Inscription (déjà gérée)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $nouvelle_societe = isset($_POST["nouvelle_societe"]) ? trim($_POST["nouvelle_societe"]) : null;
    $societe_id = isset($_POST["societe_id"]) && $_POST["societe_id"] !== "" ? $_POST["societe_id"] : null;

    if (!empty($nouvelle_societe)) {
        $query = "INSERT INTO Societe (nom) VALUES (:nom)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":nom", $nouvelle_societe);

        if ($stmt->execute()) {
            $societe_id = $db->lastInsertId();
        } else {
            echo "❌ Erreur lors de la création de la société.";
            exit();
        }
    }

    if (empty($societe_id)) {
        echo "❌ Veuillez sélectionner ou créer une société.";
        exit();
    }

    $user->nom = $nom;
    $user->email = $email;
    $user->password = $password;
    $user->societe_id = $societe_id;

    if ($user->register()) {
        echo "✅ Inscription réussie !";
    } else {
        echo "❌ Erreur lors de l'inscription.";
    }
}

// Connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        echo "❌ Email et mot de passe requis.";
        exit();
    }

    $user->email = $email;
    $user->password = $password;

    $loggedInUser = $user->login();

    if ($loggedInUser) {
        $_SESSION["user_id"] = $loggedInUser["id"];
        $_SESSION["nom"] = $loggedInUser["nom"];
        $_SESSION["email"] = $loggedInUser["email"];
        $_SESSION["societe_id"] = $loggedInUser["societe_id"];

        header("Location: ../views/dashboard.php");
        exit();
    } else {
        echo "❌ Identifiants incorrects.";
    }
}
?>

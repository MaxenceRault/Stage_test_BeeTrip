<link rel="stylesheet" href="../styles.css">
<div class="container">
    <form action="../controllers/AuthController.php" method="POST">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>

        <label for="nouvelle_societe">Créer une nouvelle société :</label>
        <input type="text" name="nouvelle_societe" placeholder="Nom de la société">

        <label for="societe_id">Ou sélectionner une société existante :</label>
        <select name="societe_id" required>
            <option value="">-- Sélectionner une société --</option>
            <?php
            require_once "../config/database.php";
            $database = new Database();
            $db = $database->getConnection();

            $stmt = $db->query("SELECT id, nom FROM Societe");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id']}'>{$row['nom']}</option>";
            }
            ?>
        </select>

        <button type="submit" name="register">S'inscrire</button>
    </form>
    <a href="./login.php">Se connecter </a>
</div>
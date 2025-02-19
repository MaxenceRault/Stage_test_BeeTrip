<link rel="stylesheet" href="../styles.css">
<div class="container">
<form action="../controllers/AuthController.php" method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit" name="login">Se connecter</button>
</form>
<a href="./register.php">S'inscrire</a>
</div>

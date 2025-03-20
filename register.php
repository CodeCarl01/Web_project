<?php
require 'config.php'; // Fichier contenant la connexion PDO à la base de données

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Vérifications
    if (empty($username) || empty($email) || empty($password)) {
        die("Tous les champs sont obligatoires.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Format d'email invalide.");
    }

    if (strlen($password) < 6) {
        die("Le mot de passe doit contenir au moins 6 caractères.");
    }

    try {
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);

        // Vérifier si l'utilisateur ou l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);
        if ($stmt->fetch()) {
            die("Nom d'utilisateur ou email déjà utilisé.");
        }

        // Hachage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insertion dans la base de données
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, balance) VALUES (:username, :email, :password, 10000.00)");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password
        ]);

        echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";

    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>
<?php
require 'config.php'; // Fichier contenant la connexion PDO à la base de données

session_start(); // Démarrer la session pour pouvoir utiliser $_SESSION

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Vérifications
    if (empty($email) || empty($password)) {
        die("Tous les champs sont obligatoires.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Format d'email invalide.");
    }

    try {
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);

        // Vérifier si l'utilisateur existe avec cet email
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user) {
            die("Aucun utilisateur trouvé avec cet e-mail.");
        }

        // Comparer le mot de passe haché avec celui fourni
        if (!password_verify($password, $user['password'])) {
            die("Le mot de passe est incorrect.");
        }

        // Connexion réussie, stocker les informations dans la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Rediriger vers la page d'accueil ou une autre page après la connexion
        header("Location: index.html"); // À remplacer par la page de destination
        exit;

    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>

<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Accès refusé.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);

    if (empty($username) || empty($email)) {
        die("Tous les champs sont obligatoires.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Format d'email invalide.");
    }

    try {
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);
        $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :user_id");
        $stmt->execute(['username' => $username, 'email' => $email, 'user_id' => $user_id]);

        echo "Mise à jour réussie.";
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>

<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Accès refusé.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];

    if (strlen($new_password) < 6) {
        die("Le nouveau mot de passe doit contenir au moins 6 caractères.");
    }

    try {
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);

        // Vérifier l'ancien mot de passe
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $user = $stmt->fetch();

        if (!password_verify($old_password, $user['password'])) {
            die("Ancien mot de passe incorrect.");
        }

        // Mettre à jour le mot de passe
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
        $stmt->execute(['password' => $hashed_password, 'user_id' => $user_id]);

        echo "Mot de passe mis à jour.";
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>

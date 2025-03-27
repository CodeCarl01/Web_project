<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Accès refusé.");
}

$user_id = $_SESSION['user_id'];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);

    session_destroy();
    header("Location: index.html");
    exit();
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<?php
/**
 * Simule des variations de prix des actions pour un projet académique
 * Cette fonction peut être exécutée via une tâche cron toutes les heures
 */
function simulateStockPriceChanges($pdo) {
    try {
        // Récupérer toutes les actions
        $stmt = $pdo->query("SELECT id, symbol, current_price FROM stocks");
        $stocks = $stmt->fetchAll();
    
        // Pour chaque action, simuler une variation de prix
        foreach ($stocks as $stock) {
            // Générer une variation aléatoire entre -3% et +3%
            $changePercent = mt_rand(-30, 30) / 10;
        
            // Calculer le nouveau prix
            $newPrice = $stock['current_price'] * (1 + ($changePercent / 100));
        
            // Arrondir à 2 décimales
            $newPrice = round($newPrice, 2);
        
            // Mettre à jour le prix dans la base de données
            $stmt = $pdo->prepare("
                UPDATE stocks 
                SET current_price = ?, 
                    last_updated = CURRENT_TIMESTAMP 
                WHERE id = ?
            ");
            $stmt->execute([$newPrice, $stock['id']]);
        
            echo "Mise à jour du prix de {$stock['symbol']} : {$stock['current_price']} € → {$newPrice} € ({$changePercent}%)\n";
        }
    
        return true;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage() . "\n";
        return false;
    }
}

// Connexion à la base de données
$host = 'localhost';
$db   = 'stockmanager';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
  
    // Exécuter la simulation
    simulateStockPriceChanges($pdo);
  
} catch (\PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage() . "\n";
}
?>
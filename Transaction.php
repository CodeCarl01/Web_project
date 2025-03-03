<?php
// Fonction pour acheter des actions
function buyStock($userId, $stockId, $quantity, $pdo) {
    try {
        // Début de la transaction pour garantir l'intégrité des données
        $pdo->beginTransaction();
    
        // 1. Obtenir le prix actuel de l'action et les informations utilisateur
        $stmt = $pdo->prepare("SELECT current_price FROM stocks WHERE id = ?");
        $stmt->execute([$stockId]);
        $stock = $stmt->fetch();
    
        $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
    
        // 2. Calculer le coût total
        $totalCost = $stock['current_price'] * $quantity;
    
        // 3. Vérifier si l'utilisateur a assez d'argent
        if ($user['balance'] < $totalCost) {
            throw new Exception("Solde insuffisant pour effectuer cette transaction.");
        }
    
        // 4. Mettre à jour le solde de l'utilisateur
        $stmt = $pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
        $stmt->execute([$totalCost, $userId]);
    
        // 5. Mettre à jour ou créer une entrée dans le portefeuille
        $stmt = $pdo->prepare("
            SELECT id, quantity, avg_purchase_price FROM portfolio 
            WHERE user_id = ? AND stock_id = ?
        ");
        $stmt->execute([$userId, $stockId]);
        $portfolio = $stmt->fetch();
    
        if ($portfolio) {
            // Calculer le nouveau prix d'achat moyen
            $totalShares = $portfolio['quantity'] + $quantity;
            $totalValue = ($portfolio['quantity'] * $portfolio['avg_purchase_price']) + $totalCost;
            $newAvgPrice = $totalValue / $totalShares;
        
            // Mettre à jour l'entrée existante
            $stmt = $pdo->prepare("
                UPDATE portfolio 
                SET quantity = quantity + ?, avg_purchase_price = ? 
                WHERE id = ?
            ");
            $stmt->execute([$quantity, $newAvgPrice, $portfolio['id']]);
        } else {
            // Créer une nouvelle entrée
            $stmt = $pdo->prepare("
                INSERT INTO portfolio (user_id, stock_id, quantity, avg_purchase_price) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$userId, $stockId, $quantity, $stock['current_price']]);
        }
    
        // 6. Enregistrer la transaction
        $stmt = $pdo->prepare("
            INSERT INTO transactions (user_id, stock_id, type, quantity, price, total_amount) 
            VALUES (?, ?, 'buy', ?, ?, ?)
        ");
        $stmt->execute([$userId, $stockId, $quantity, $stock['current_price'], $totalCost]);
    
        // Valider la transaction
        $pdo->commit();
    
        return [
            'success' => true,
            'message' => "Achat réussi de $quantity actions pour un total de $totalCost €"
        ];
    
    } catch (Exception $e) {
        // En cas d'erreur, annuler toutes les modifications
        $pdo->rollBack();
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

// Fonction pour vendre des actions
function sellStock($userId, $stockId, $quantity, $pdo) {
    try {
        // Début de la transaction pour garantir l'intégrité des données
        $pdo->beginTransaction();
    
        // 1. Vérifier si l'utilisateur possède assez d'actions
        $stmt = $pdo->prepare("
            SELECT id, quantity, avg_purchase_price FROM portfolio 
            WHERE user_id = ? AND stock_id = ?
        ");
        $stmt->execute([$userId, $stockId]);
        $portfolio = $stmt->fetch();
    
        if (!$portfolio || $portfolio['quantity'] < $quantity) {
            throw new Exception("Vous ne possédez pas assez d'actions pour effectuer cette vente.");
        }
    
        // 2. Obtenir le prix actuel de l'action
        $stmt = $pdo->prepare("SELECT current_price FROM stocks WHERE id = ?");
        $stmt->execute([$stockId]);
        $stock = $stmt->fetch();
    
        // 3. Calculer le montant total de la vente
        $totalAmount = $stock['current_price'] * $quantity;
    
        // 4. Mettre à jour le solde de l'utilisateur
        $stmt = $pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $stmt->execute([$totalAmount, $userId]);
    
        // 5. Mettre à jour le portefeuille
        if ($portfolio['quantity'] == $quantity) {
            // Supprimer l'entrée si toutes les actions sont vendues
            $stmt = $pdo->prepare("DELETE FROM portfolio WHERE id = ?");
            $stmt->execute([$portfolio['id']]);
        } else {
            // Mettre à jour la quantité
            $stmt = $pdo->prepare("
                UPDATE portfolio 
                SET quantity = quantity - ? 
                WHERE id = ?
            ");
            $stmt->execute([$quantity, $portfolio['id']]);
        }
    
        // 6. Enregistrer la transaction
        $stmt = $pdo->prepare("
            INSERT INTO transactions (user_id, stock_id, type, quantity, price, total_amount) 
            VALUES (?, ?, 'sell', ?, ?, ?)
        ");
        $stmt->execute([$userId, $stockId, $quantity, $stock['current_price'], $totalAmount]);
    
        // Valider la transaction
        $pdo->commit();
    
        return [
            'success' => true,
            'message' => "Vente réussie de $quantity actions pour un total de $totalAmount €"
        ];
    
    } catch (Exception $e) {
        // En cas d'erreur, annuler toutes les modifications
        $pdo->rollBack();
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}
?>
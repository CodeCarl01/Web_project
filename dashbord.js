// Données pour le graphique d'évolution du portefeuille
const portfolioData = {
    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil'],
    datasets: [{
        label: 'Valeur du portefeuille (€)',
        data: [8500, 8700, 9200, 9100, 9600, 9800, 10245.67],
        backgroundColor: 'rgba(52, 152, 219, 0.1)',
        borderColor: 'rgba(52, 152, 219, 1)',
        borderWidth: 2,
        pointBackgroundColor: 'rgba(52, 152, 219, 1)',
        pointRadius: 4,
        tension: 0.2 // Pour avoir des courbes plus douces
    }]
};

// Configuration du graphique
const portfolioChartConfig = {
    type: 'line',
    data: portfolioData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            label += new Intl.NumberFormat('fr-FR', { 
                                style: 'currency', 
                                currency: 'EUR' 
                            }).format(context.parsed.y);
                        }
                        return label;
                    }
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: false,
                ticks: {
                    callback: function(value) {
                        return new Intl.NumberFormat('fr-FR', { 
                            style: 'currency', 
                            currency: 'EUR',
                            maximumFractionDigits: 0
                        }).format(value);
                    }
                }
            }
        }
    }
};

// Initialiser le graphique lorsque le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('portfolioChart').getContext('2d');
    new Chart(ctx, portfolioChartConfig);
  
    // Ajouter des écouteurs d'événements pour les boutons
    document.querySelectorAll('.btn-buy').forEach(button => {
        button.addEventListener('click', function(e) {
            const row = e.target.closest('tr');
            const symbol = row.cells[0].textContent;
            const name = row.cells[1].textContent;
            openTransactionModal('buy', symbol, name);
        });
    });
  
    document.querySelectorAll('.btn-sell').forEach(button => {
        button.addEventListener('click', function(e) {
            const row = e.target.closest('tr');
            const symbol = row.cells[0].textContent;
            const name = row.cells[1].textContent;
            openTransactionModal('sell', symbol, name);
        });
    });
});

// Fonction pour ouvrir une modale de transaction (à implémenter)
function openTransactionModal(type, symbol, name) {
    console.log(`Ouvrir modale pour ${type === 'buy' ? 'acheter' : 'vendre'} ${name} (${symbol})`);
    // Ici vous ajouteriez le code pour ouvrir une modale avec un formulaire de transaction
    alert(`${type === 'buy' ? 'Achat' : 'Vente'} de ${name} (${symbol})`);
}
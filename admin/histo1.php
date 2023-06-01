<?php
// Connexion à la base de données
$con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');



// Récupération des données des moyennes par classe
$sql = "SELECT nom_classe, AVG(moyenne) AS moyenne_classe FROM eleve  WHERE (nom_classe LIKE '3AP_') 
OR (nom_classe LIKE '4AP_') 
OR (nom_classe LIKE '5AP_' ) GROUP BY nom_classe ";

$result = $con->query($sql);

// Tableau pour stocker les données des classes et des moyennes
$classes = array();
$moyennes = array();

// Récupération des résultats de la requête
while ($row = $result->fetch_assoc()) {
    $classes[] = $row['nom_classe'];
    $moyennes[] = $row['moyenne_classe'];
}

// Fermeture de la connexion à la base de données
$con->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Histogramme - Moyenne des moyennes par classe</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <canvas id="histogram"></canvas>

    <script>
        // Récupération des données depuis PHP
        var classes = <?php echo json_encode($classes); ?>;
        var moyennes = <?php echo json_encode($moyennes); ?>;

        // Création de l'histogramme avec Chart.js
        var ctx = document.getElementById('histogram').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: classes,
                datasets: [{
                    label: 'Moyenne des moyennes',
                    data: moyennes,
                    backgroundColor: 'rgba(75, 192, 192, 0.8)', // Couleur de remplissage des barres
                    borderColor: 'rgba(75, 192, 192, 1)', // Couleur des bordures des barres
                    borderWidth: 1 // Épaisseur des bordures des barres

                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },


                barThickness: 20, // Largeur des barres en pixels
                maxBarThickness: 40 // Largeur maximale des barres en pixels
            }
        });
    </script>
</body>

</html>
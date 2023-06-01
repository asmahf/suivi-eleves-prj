<?php
// Connexion à la base de données
$con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');

// Récupération des données des moyennes par classe
$sql = "SELECT nom_classe, AVG(moyenne) AS moyenne_classe FROM eleve WHERE (nom_classe LIKE '3AP_') OR (nom_classe LIKE '4AP_') OR (nom_classe LIKE '5AP_') GROUP BY nom_classe ";
$result = $con->query($sql);

// Tableau pour stocker les données des classes et des moyennes
$classes = array();
$moyennes = array();

// Récupération des résultats de la requête
while ($row = $result->fetch_assoc()) {
    $classes[] = $row['nom_classe'];
    $moyennes[] = $row['moyenne_classe'];
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>TamayouZ</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main1.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <main class="header">

        <!-- <nav class="navbar navbar-expand-lg bg-body-tertiary"> -->
        <nav class="navbar navbar-expand-lg ">
            <div class="container">
                <a class="navbar-brand" href="#description">TamayouZ</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                    <ul class="navbar-nav ">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Acceuil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./recup-emploi.php">Emplois</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./recupub.php">Publication</a>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="products">
            <div class="all-products">
                <div class="product">
                    <img src="./pic/users/admin-settings-male.png">

                    <div class="product-info">
                        <h4 class="product-title"> Administration</h4>
                        <!-- <p class="product-desc">Si vous etes dans cette categorie, cliquez sur le boutton pour entrer</p> -->
                        <a class="product-btn" href="login-admin.php">Se Connecter</a>

                    </div>
                </div>
                <div class="product">
                    <img src="./pic/users/family.png">
                    <div class="product-info">
                        <h4 class="product-title">Parents</h4>
                        <!-- <p class="product-desc">Si vous etes dans cette categorie, cliquez sur le boutton pour entrer</p> -->
                        <a class="product-btn" href="login-parent.php">Se Connecter</a>

                    </div>
                </div>
                <div class="product">
                    <img src="./pic/users/female-teacher.png">
                    <!-- <img src="./pic/users/historian-female-skin-type-3.png"> -->
                    <h4 class="product-title">Enseignants</h4>
                    <!-- <p class="product-desc">Si vous etes dans cette categorie, cliquez sur le boutton pour entrer</p> -->
                    <a class="product-btn" href="login-teacher.php">Se Connecter</a>

                </div>
            </div>
            </div>
        </section>
        <div class="containers-grid ">

            <div class="container page">
                <div class="text-space" id="description">
                    <h2>TamayouZ</h2>
                    <p>Bienvenue sur "TamayouZ", un espace dédié à la collaboration entre parents, enseignants et administration. Notre plateforme est votre allié pour accompagner la réussite scolaire de vos enfants en suivant leurs notes d'evaluation, devoirs et remarques ajoutés par l'enseignant,ainsi que les activités et les annonces. Ensemble, nous formons une communauté engagée dans l'éducation, pour le bien-être et l'épanouissement de chaque élève. Rejoignez-nous et construisons ensemble un avenir prometteur pour nos enfants.</p>
                </div>
            </div>

            <div class="container page">
                <div class="text-space">
                    <h2> Moyennes Par Classe</h2>
                    <canvas id="histogram"></canvas>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        // Récupération des données depuis PHP
                        var classes = <?php echo json_encode($classes); ?>;
                        var moyennes = <?php echo json_encode($moyennes); ?>;

                        // Création de l'histogramme avec Chart.js
                        var ctx = document.getElementById('histogram').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: classes,
                                datasets: [{
                                    label: 'Moyennes par classe',
                                    data: moyennes,
                                    backgroundColor: 'rgba(96, 165, 250, 0.2)',
                                    borderColor: 'rgba(96, 165, 250, 1)',
                                    // backgroundColor: 'rgba(59, 131, 246, 0.2)',
                                    // borderColor: 'rgba(59, 131, 246, 1)',
                                    // backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    // borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>


</body>

</html>
<?php  // Fermeture de la connexion à la base de données
$con->close(); ?>
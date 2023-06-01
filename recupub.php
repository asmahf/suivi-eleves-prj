<?php
if (!isset($_SESSION)) {
    session_start();
}
require './config/database.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Gestion des publications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #555;
        }

        h1 {
            color: #555;
            text-align: center;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .publication {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            flex: 0 0 30%;
        }

        .publication small {
            color: #888;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" href="../../../../../../suivi-eleves-prj/css/style.css">
</head>

<body>

    <main class="min-vh-100">
        <h1>Publication</h1>

        <div class="container">
            <?php

            // Récupérer toutes les publications de type "annonce" ou "activite" de la table
            $sql = "SELECT * FROM publication WHERE type_pub IN ('annonce', 'activite')";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $typePublication = $row["type_pub"];
                    $contenuPublication = $row["contenu_pub"];

                    echo "<div class='card publication shadow rounded'>";
                    echo "<p><strong>Type:</strong> $typePublication</p>";
                    echo "<p>$contenuPublication</p>";
                    echo "</div>";
                }
            } else {
                echo "Aucune publication n'a été trouvée.";
            }

            // Fermeture de la connexion
            $con->close();
            ?>
        </div>
    </main>
</body>

</html>
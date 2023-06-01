<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../config/database.php';
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
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include './sidebar.php'; ?>
    <main>
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
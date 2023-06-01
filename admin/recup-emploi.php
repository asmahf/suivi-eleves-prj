<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../config/database.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Gestion des emplois</title>
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
        <h1>Emplois du temps</h1>

        <div class="container">
            <?php

            // Récupérer toutes les publications de type "emplois_du_temps"  de la table
            $sql = "SELECT id_pub, nom_emploi FROM publication WHERE type_pub='emplois_du_temps'";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id_pub = $row["id_pub"];
                    $nom_emplois = $row["nom_emploi"];
                    // $contenuPublication = $row["contenu_pub"];

                    echo "<div class='card publication shadow rounded'>";
                    echo "<p><strong>Nom_emploi: </strong><a href='emploi.php?id_pub=$id_pub'>$nom_emplois</a></p>";
                    echo "<p>$nom_emplois</p>";
                    echo "</div>";
                }
            } else {
                echo "Aucune emploi n'a été trouvée.";
            }

            // Fermeture de la connexion
            $con->close();
            ?>
        </div>
    </main>
</body>

</html>
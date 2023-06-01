<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../config/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emplois du temps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 113px;
            padding: 20px;
            border: 2px solid;
        }
    </style>
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include './sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="card-body">
                <div class="form">
                    <form action="emploi-temps.php" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="description">Description :</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="pdf formFile" class="form-label">Fichier PDF :</label>
                            <input class="form-control" type="file" name="pdf" accept="application/pdf">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="type_pub" value="emplois_du_temps">
                            <button type="submit" name="publish" class="btn btn-primary">Publier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST['publish'])) {
            $id_admin = $_SESSION['user']->id_utilis;
            $description = $_POST['description'];
            $type_pub = $_POST['type_pub'];
            // $type_pub = 'emplois_du_temps';
            // Vérifier si un fichier a été téléchargé avec succès
            if ($_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
                // Récupérer le chemin temporaire du fichier PDF
                $tmpFile = $_FILES['pdf']['tmp_name'];

                // Lire le contenu du fichier PDF
                $fileContent = file_get_contents($tmpFile);

                // Préparer la requête d'insertion avec un paramètre pour le contenu du fichier
                $insertQuery = "INSERT INTO publication (contenu_pub,fichier_emploi,type_pub,id_admin) VALUES (?,?,?,?)";
                $stmt = mysqli_prepare($con, $insertQuery);

                // Lier le paramètre au contenu du fichier
                mysqli_stmt_bind_param($stmt, 'sssi', $description, $fileContent, $type_pub,   $id_admin);
                // Exécuter la requête d'insertion
                if (mysqli_stmt_execute($stmt)) {
                    echo "Le fichier PDF a été inséré avec succès dans la base de données.";
                } else {
                    echo "Erreur lors de l'insertion du fichier PDF ";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Erreur lors du téléchargement du fichier PDF.";
            }

            // Fermer la connexion à la base de données
            $con->close();
        }
        ?>
    </main>
</body>

</html>
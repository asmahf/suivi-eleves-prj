<?php
require '../config/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>devoir</title>
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <main>

        <?php

        if (isset($_GET['enfant'])) {
            $prenom_enfant = $_GET['enfant'];



            // Récupération de l'id de l'eleve sélectionnée
            $sql = "SELECT id_eleve FROM eleve WHERE prenom_eleve = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 's', $prenom_enfant);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $id_eleve);
            mysqli_stmt_fetch($stmt);

            // récupérer l'ID de la fiche de suivi de l'élève
            $sql = "SELECT id_fiche FROM fiche_eleve WHERE id_eleve = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $id_eleve);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $id_fiche);
            mysqli_stmt_fetch($stmt);

            //Afficher le devoir
            $sql = "SELECT delai_devoir, contenu_devoir, nom_matiere FROM devoir WHERE id_fiche = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $id_fiche);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $delai_devoir, $contenu_devoir, $nom_matiere);


            // Affichage des devoirs
            echo "<h1 class='text-center'><b>Devoirs </b></h1>";
            echo " <div class='row row-cols-1 row-cols-md-3 g-4'>";
            while (mysqli_stmt_fetch($stmt)) {
                echo "<div class='col'>";
                echo "<div class='card border-primary'>";
                echo "<div class='card-body'>";
                // echo "<h5 class='card-title'>Devoir</h5>";
                echo "<p class='card-text'> <b> Matiere: </b> $nom_matiere</p>";
                echo "<p class='card-text'> <b> Contenu: </b> $contenu_devoir</p>";
                echo "<p class='card-text'> <b>Délai: </b> $delai_devoir</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
    </main>
</body>

</html>
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
    <title>Moyenne </title>
</head>

<body>

    <?php include '../header/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <main>


        <?php
        if (isset($_GET['enfant'])) {
            $id_parent = $_SESSION['user']->id_utilis;

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

            //Afficher les notes
            $sql = "SELECT valeur_note, nom_matiere FROM note WHERE id_fiche = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $id_fiche);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $note, $nom_matiere);


            echo "<div class='card mx-auto mt-4 lh-lg'style='max-width: 30rem;'>";
            echo "<div class='card-header' style='font-size: 1.2rem; font-weight: 700;'>Les notes de votre enfant </div>";

            $hr = 0;
            echo "<div class='card-body'>";
            // Affichage des notes
            while (mysqli_stmt_fetch($stmt)) {

                if ($hr != 0) {
                    echo "<hr> ";
                }
                echo " <p class='card-text'><span  style='font-size: 1.2rem;' >$nom_matiere: </span> $note/10</p>";
                $hr = 1;
            }
            echo "</div>";
            $hr = 0;


            // Calculer et insérer la moyenne dans la table "eleve"
            $sql = "UPDATE eleve SET moyenne = (SELECT AVG(valeur_note) AS moyenne FROM note WHERE id_fiche = ?) WHERE id_parent = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'ii', $id_fiche, $id_parent);
            mysqli_stmt_execute($stmt);
            // Récupérer la moyenne mise à jour
            $sql = "SELECT moyenne FROM eleve WHERE id_parent = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $id_parent);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $moyenne);
            mysqli_stmt_fetch($stmt);


            echo "<div class='card-footer'>";
            echo "<h5 class='card-title' style='font-size: 1.2rem; font-weight: 700;'>Moyenne :</h5>";
            echo "<p class='card-text' style='font-size: 1.1rem;'>La moyenne est: $moyenne</p>";
            echo "</div>";
        }
        ?>
    </main>
</body>

</html>
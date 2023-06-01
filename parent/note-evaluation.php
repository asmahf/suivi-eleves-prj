<?php

require '../config/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            //récupérer  la note de l'élève
            $sql = "SELECT date_evaluation, note FROM evaluation15jrs WHERE id_fiche = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $id_fiche);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $date_evaluation, $note);


            // Affichage des notes
            echo "<h1 class='text-center'><b>Note d'evaluation 15jours </b></h1>";
            echo " <div class='row row-cols-1 row-cols-md-3 g-4'>";
            while (mysqli_stmt_fetch($stmt)) {
                echo "<div class='col'>";
                echo "<div class='card border-primary'>";
                echo "<div class='card-body'>";
                // echo "<h5 class='card-title'>Devoir</h5>";
                echo "<p class='card-text'> <b> Date d'evaluation : $date_evaluation </b></p>";
                echo "<p class='card-text'> <b> Note: </b> $note</p>";

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
<?php
require '../config/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remarque</title>
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

            // //Afficher la remarque
            $sql = "SELECT r.contenu_remarque, u.nom_utilis, u.prenom_utilis
            FROM remarques AS r
            INNER JOIN utilisateur AS u ON r.id_enseignant = u.id_utilis
            WHERE r.id_fiche = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $id_fiche);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $contenu_remarque, $nom_utilis, $prenom_utilis);

            // Affichage des remarques
            echo "<div class='card  border-primary mx-auto mt-4 lh-lg'style='max-width: 40rem;'>";
            echo "<div class='card-header' style='font-size: 1.2rem; font-weight: 700;'>Les remarques de votre enfant </div>";
            $hr = 0;
            echo "<div class='card-body'>";
            while (mysqli_stmt_fetch($stmt)) {
                if ($hr != 0) {
                    echo "<hr> ";
                }
                echo "<p class='card-text'> <b> Enseignant: </b> $nom_utilis $prenom_utilis</p>";
                echo "<p class='card-text'> <b> La remarque: </b> $contenu_remarque</p>";
                $hr = 1;
            }
            echo "</div>";
            echo "</div>";
            $hr = 0;
        }
        ?>
    </main>
</body>

</html>
<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../config/database.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Liste des eleves </title>
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <main>


        <div class="container mt-5">
            <section class="content">
                <div class="row">
                    <div class="card-body">
                        <div class="mb-3">
                            <form method="GET" action="liste-eleves.php">
                                <label for="classe">Choisir une classe :</label>
                                <select name="classe" id="classe">
                                    <?php
                                    $con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');
                                    $id_enseignant = $_SESSION['user']->id_utilis; // à adapter selon votre contexte
                                    $sql = "SELECT c.nom_classe FROM classe c LEFT JOIN enseigner e ON c.nom_classe = e.nom_classe WHERE e.id_enseignant = ?";
                                    $stmt = mysqli_prepare($con, $sql);
                                    mysqli_stmt_bind_param($stmt, 'i', $id_enseignant);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <option value="<?= $row['nom_classe']; ?>"><?= $row['nom_classe']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="showlist" class="btn btn-primary btn-sm">Afficher la liste des élèves</button>
                        </div>

                    </div>
            </section>
        </div>

        <?php
        if (isset($_GET['showlist'])) {
            $nom_classe = $_GET['classe'];

            // Vérifier que l'enseignant enseigne bien cette classe
            $sql = "SELECT * FROM enseigner WHERE id_enseignant = ? AND nom_classe = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'is', $id_enseignant, $nom_classe);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 0) {
                echo "Vous n'êtes pas autorisé à accéder à cette classe.";
                exit;
            }

            // Récupérer la liste des élèves pour cette classe
            $sql = "SELECT * FROM eleve WHERE nom_classe = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 's', $nom_classe);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Afficher la liste des élèves
            echo '<div class="container mt-4">';
            echo ' <div class="row">';
            echo '<div class="col-md-12">';
            echo '<div class="card">';
            echo '<div class="card-header">';
            echo ' <h4>Tous les eleves </h4>';
            echo ' </div>';
            echo '<div class="card-body">';

            echo '<table class="table table-bordered table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Nom</th>';
            echo '<th>Prenom</th>';
            echo '<th>Date de naissance</th>';
            echo '<th>Code eleve</th>';
            echo ' <th>Classe</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<th scope="row">' . $i . '</th>';

                echo '<td>' . $row['nom_eleve'] . '</td>';
                echo '<td>' . $row['prenom_eleve'] . '</td>';
                echo '<td>' . $row['date_naiss_eleve'] . '</td>';
                echo '<td>' . $row['code_eleve'] . '</td>';
                echo '<td>' . $row['nom_classe'] . '</td>';
                echo '</tr>';
                $i++;
            }
            echo ' </tbody>';
            echo '</table>';

            echo ' </div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } ?>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
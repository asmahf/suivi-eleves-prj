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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>Message d'urgence</title>
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="container mt-5">

            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h4> Contacter les parents des eleves en urgence
                                <a href="index.php" class="btn btn-danger float-end">Retour</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <form method="GET" action="message-urgence.php">
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
                                <button type="submit" name="showlist" class="btn btn-primary btn">Afficher la liste des parents</button>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
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

                // récupérer les données des élèves et de leurs parents
                $sql = "SELECT e.nom_eleve, e.prenom_eleve, u.nom_utilis, u.prenom_utilis, u.email, u.n°_tlph FROM eleve e JOIN utilisateur u  ON e.id_parent = u.id_utilis WHERE type_utilis='parent' AND e.nom_classe=? ";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, 's', $nom_classe);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                // $result = mysqli_query($con, $sql);

                // afficher les résultats sous forme de table HTML
                echo '<div class="mt-3">';
                echo '<table class="table  table-bordered">';
                echo '<thead><tr>
            <th scope="col">#</th>
            <th>Elève</th>
            <th>Parent</th>
            <th>Email</th>
            <th>Téléphone</th>
            </tr></thead';
                echo '<tbody>';
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo '<th scope="row">' . $i . '</th>';
                    echo "<td>" . $row['nom_eleve'] . " " . $row['prenom_eleve'] . "</td>";
                    echo "<td>" . $row['nom_utilis'] . " " . $row['prenom_utilis'] . "</td>";
                    echo "<td><a href='mailto:" . $row['email'] . " ' target='_blank'>" . $row['email'] . " </a></td>";
                    echo "<td><a href='tel:" . $row['n°_tlph'] . "'>" . $row['n°_tlph'] . "</a></td>";
                    echo "</tr>";
                    $i++;
                }
                echo "</tbody>";
                echo "</table>";
                echo ' </div>';
            }
            // fermer la connexion à la base de données
            mysqli_close($con);
            ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
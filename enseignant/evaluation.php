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

    <title>Note evaluation</title>
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <main>

        <div class="container mt-5">

            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h4> Evaluer les eleves
                                <a href="index.php" class="btn btn-danger float-end">Retour</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <form method="GET" action="evaluation.php">
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
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_GET['showlist'])) {
                $con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');

                // Récupérer l'enseignant et la classe sélectionnée depuis l'URL

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

                echo '<div class="mt-5">';
                echo "<h3>La liste des élèves de la classe <b> $nom_classe </b> :</h3>";
                echo '<form method="POST" action="enregistrer.php">';
                echo '<table class="table  table-bordered">';
                echo '<thead><tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col" >Date de naissance</th>
            <th scope="col">Note</th>
            
            </tr></thead>';
                echo '<tbody>';
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<th scope="row">' . $i . '</th>';
                    echo '<td>' . $row['nom_eleve'] . '</td>';
                    echo '<td>' . $row['prenom_eleve'] . '</td>';
                    echo '<td>' . $row['date_naiss_eleve'] . '</td>';
                    echo '<td><input type="number" name="notes[' . $row['id_eleve'] . ']" min="0" max="10" step="0.5" value="' . (isset($row['note']) ? $row['note'] : '') . '"></td>';
                    echo '<input type="hidden" name="id_eleve[' . $row['id_eleve'] . ']" value="' . $row['id_eleve'] . '">';
                    echo '</tr>';
                    $i++;
                }
                echo '</tbody>';
                echo '</table>';
                echo '<input type="submit" class="btn btn-success" name="submit_notes" value="Enregistrer les notes">';
                echo '</form>';
                echo ' </div>';
            }
            ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
require '../database.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Les details d'enseignant</title>
</head>

<body>
    <?php include '../../header/header.php'; ?>
    <?php include '../sidebar.php'; ?>
    <main>

        <div class="container mt-5">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Les details d'enseignant
                                <a href="teacher.php" class="btn btn-danger float-end">Retour</a>
                            </h4>
                        </div>
                        <div class="card-body">

                            <?php
                            if (isset($_GET['id'])) {
                                $teacher_id = mysqli_real_escape_string($con, $_GET['id']);
                                $query = "SELECT * FROM utilisateur WHERE id_utilis='$teacher_id' AND type_utilis='enseignant';";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    $teacher = mysqli_fetch_array($query_run);
                            ?>

                                    <div class="mb-3">
                                        <label>Nom</label>
                                        <p class="form-control">
                                            <?= $teacher['nom_utilis']; ?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Prenom</label>
                                        <p class="form-control">
                                            <?= $teacher['prenom_utilis']; ?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Date de naissance</label>
                                        <p class="form-control">
                                            <?= $teacher['date_de_naissance']; ?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Adresse</label>
                                        <p class="form-control">
                                            <?= $teacher['adresse_utilis']; ?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Numero telephone</label>
                                        <p class="form-control">
                                            <?= $teacher['n°_tlph']; ?>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label>Email</label>
                                        <p class="form-control">
                                            <?= $teacher['email']; ?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Mot de passe</label>
                                        <p class="form-control">
                                            <?= $teacher['mot_de_passe']; ?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Classes enseigne</label>
                                        <?php
                                        // Exécuter la requête SELECT pour récupérer la matière enseignée
                                        $sql = "SELECT GROUP_CONCAT(DISTINCT enseigner.nom_classe) AS classes FROM enseigner WHERE id_enseignant = ?";
                                        $stmt = mysqli_prepare($con, $sql);
                                        mysqli_stmt_bind_param($stmt, 'i', $teacher['id_utilis']);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_bind_result($stmt, $classesEnseignee);
                                        mysqli_stmt_fetch($stmt);
                                        mysqli_stmt_close($stmt);
                                        ?>
                                        <p class="form-control">
                                            <?= str_replace(",", ", ", $classesEnseignee) ?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>matières enseigne</label>
                                        <?php
                                        // Exécuter la requête SELECT pour récupérer la matière enseignée
                                        $sql = "SELECT GROUP_CONCAT(DISTINCT nom_matiere) AS matieres FROM enseigner_matiere WHERE id_enseignant = ?";
                                        $stmt = mysqli_prepare($con, $sql);
                                        mysqli_stmt_bind_param($stmt, 'i', $teacher['id_utilis']);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_bind_result($stmt, $matieresEnseignee);
                                        mysqli_stmt_fetch($stmt);
                                        mysqli_stmt_close($stmt);
                                        ?>
                                        <p class="form-control">
                                            <?= str_replace(",", ", ", $matieresEnseignee) ?>
                                        </p>
                                    </div>

                            <?php
                                } else {
                                    echo "<h4>No Such Id Found</h4>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
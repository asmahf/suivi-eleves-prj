<?php
require './dbcon.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Les details de l'eleve</title>
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
                            <h4>Les details de l'eleve
                                <a href="index.php" class="btn btn-danger float-end">Retour</a>
                            </h4>
                        </div>
                        <div class="card-body">

                            <?php
                            if (isset($_GET['id'])) {
                                $id_eleve = mysqli_real_escape_string($con, $_GET['id']);
                                $query = "SELECT * FROM eleve WHERE id_eleve='$id_eleve' ";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    $eleve = mysqli_fetch_array($query_run);
                            ?>

                                    <div class="mb-3">
                                        <label>nom</label>
                                        <p class="form-control">
                                            <?= $eleve['nom_eleve']; ?>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label>Prenom</label>
                                        <p class="form-control">
                                            <?= $eleve['prenom_eleve']; ?>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label>Date De Naissance</label>
                                        <p class="form-control">
                                            <?= $eleve['date_naiss_eleve']; ?>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label>Sexe</label>
                                        <p class="form-control">
                                            <?= $eleve['sexe']; ?>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label>Classe</label>
                                        <p class="form-control">
                                            <?= $eleve['nom_classe']; ?>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label>Code</label>
                                        <p class="form-control">
                                            <?= $eleve['code_eleve']; ?>
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

        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
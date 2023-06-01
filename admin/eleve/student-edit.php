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

    <title>Modifier eleve</title>
</head>

<body>
    <?php include '../../header/header.php'; ?>
    <?php include '../sidebar.php'; ?>
    <main>


        <div class="container mt-5">

            <?php include('message.php'); ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Modifier eleve
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
                                    <form action="code.php" method="POST">
                                        <input type="hidden" name="id_eleve" value="<?= $eleve['id_eleve']; ?>">

                                        <div class="mb-3">
                                            <label>Nom Eleve</label>
                                            <input type="text" name="nom_eleve" value="<?= $eleve['nom_eleve']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Prenom Eleve</label>
                                            <input type="text" name="prenom_eleve" value="<?= $eleve['prenom_eleve']; ?>" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Date De Naissance Eleve</label>
                                            <input type="date" name="date_naiss_eleve" value="<?= $eleve['date_naiss_eleve']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Sexe</label>

                                            <input type="radio" name="sexe" value="garçon" checked>
                                            <label>Garçon</label>

                                            <input type="radio" name="sexe" value="fille">
                                            <label>Fille</label>

                                        </div><br />
                                        <div class="mb-3">
                                            <label>Classe</label>
                                            <select name="nom_classe" value=<?= $eleve['nom_classe']; ?> class=" form-control">

                                                <?php
                                                $con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');
                                                $name_classe = " SELECT nom_classe FROM `classe`";
                                                $name_classe_run = mysqli_query($con, $name_classe);

                                                if (mysqli_num_rows($name_classe_run)) {
                                                    foreach ($name_classe_run as $row) {
                                                ?>
                                                        <option value=<?= $row['nom_classe']; ?>> <?= $row['nom_classe']; ?></option>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <option value=""> il n'y a pas de classe </option>
                                                <?php
                                                }
                                                ?>

                                            </select>
                                        </div>


                                        <div class="mb-3">
                                            <label>Code</label>
                                            <input type="text" name="code_eleve" value=<?= $eleve['code_eleve']; ?> class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" name="update_eleve" class="btn btn-primary">
                                                Modifier
                                            </button>
                                        </div>

                                    </form>
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
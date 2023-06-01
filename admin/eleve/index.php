<?php
// if(!isset($_SESSION)) 
{
    session_start();
}
require './dbcon.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>liste des élèves</title>
</head>

<body>
    <?php include '../../header/header.php'; ?>
    <?php include '../sidebar.php'; ?>
    <main>

        <div class="container mt-4">

            <?php include('message.php'); ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tous les eleves
                                <a href="student-create.php" class="btn btn-primary float-end">Ajouter eleve</a>
                            </h4>
                        </div>
                        <div class="card-body">

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Date De Naissance</th>
                                        <th>Sexe</th>
                                        <th>Classe</th>
                                        <th>Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM eleve";
                                    $query_run = mysqli_query($con, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $eleve) {
                                    ?>
                                            <tr>
                                                <td><?= $eleve['id_eleve']; ?></td>
                                                <td><?= $eleve['nom_eleve']; ?></td>
                                                <td><?= $eleve['prenom_eleve']; ?></td>
                                                <td><?= $eleve['date_naiss_eleve']; ?></td>
                                                <td><?= $eleve['sexe']; ?></td>
                                                <td><?= $eleve['nom_classe']; ?></td>
                                                <td><?= $eleve['code_eleve']; ?></td>
                                                <td>
                                                    <a href="student-view.php?id=<?= $eleve['id_eleve']; ?>" class="btn btn-info btn-sm">Voir</a>
                                                    <a href="student-edit.php?id=<?= $eleve['id_eleve']; ?>" class="btn btn-success btn-sm">modifier</a>
                                                    <form action="code.php" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_eleve" value="<?= $eleve['id_eleve']; ?>" class="btn btn-danger btn-sm">supprimer</button>
                                                    </form>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<h5> No Record Found </h5>";
                                    }
                                    ?>

                                </tbody>
                            </table>

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
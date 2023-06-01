<?php
if (!isset($_SESSION)) {
    session_start();
}
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

    <title>Liste parents</title>
</head>

<body>
    <?php include '../../header/header.php'; ?>
    <?php include '../sidebar.php'; ?>
    <main>
        <div class="container mt-4">

            <?php include('../eleve/message.php'); ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Les details de parent</h4>
                        </div>
                        <div class="card-body">

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Date De Naissance</th>
                                        <th>Adresse</th>
                                        <th>n°_tlph</th>
                                        <th>email</th>
                                        <th>motdepasse</th>
                                        <th>profession</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM utilisateur where type_utilis='parent'";
                                    $query_run = mysqli_query($con, $query);

                                    if (mysqli_num_rows($query_run) > 0) {

                                        foreach ($query_run as $parent) {
                                    ?>
                                            <tr>
                                                <td><?= $parent['id_utilis']; ?></td>
                                                <td><?= $parent['nom_utilis']; ?></td>
                                                <td><?= $parent['prenom_utilis']; ?></td>
                                                <td><?= $parent['date_de_naissance']; ?></td>
                                                <td><?= $parent['adresse_utilis']; ?></td>
                                                <td><?= $parent['n°_tlph']; ?></td>
                                                <td><?= $parent['email']; ?></td>
                                                <td><?= $parent['mot_de_passe']; ?></td>
                                                <td><?= $parent['profession']; ?></td>


                                                <td>

                                                    <form action="code.php" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_parent" value="<?= $parent['id_utilis']; ?>" class="btn btn-danger btn-sm">Supprimer</button>
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
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
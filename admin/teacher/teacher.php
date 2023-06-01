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

    <title>Liste des enseignants</title>
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
                            <h4>Tous les enseignants
                                <a href="add-teacher.php" class="btn btn-primary float-end">Ajouter enseignant</a>
                            </h4>
                        </div>
                        <div class="card-body">

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Date de naissance</th>
                                        <th>Adresse</th>
                                        <th>Numero telephone</th>
                                        <th>Email</th>
                                        <th>Mot de passe</th>
                                        <th>Classe</th>
                                        <th>Matiere</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT
                                    utilisateur.*,
                                    enseigner.nom_classe,
                                    enseigner_matiere.nom_matiere
                                FROM
                                    utilisateur
                                JOIN enseigner ON utilisateur.id_utilis = enseigner.id_enseignant
                                JOIN classe ON enseigner.nom_classe = classe.nom_classe
                                JOIN enseigner_matiere ON utilisateur.id_utilis = enseigner_matiere.id_enseignant
                                WHERE
                                    utilisateur.type_utilis = 'enseignant';";

                                    $query_run = mysqli_query($con, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $teacher) {
                                    ?>
                                            <tr>
                                                <td><?= $teacher['id_utilis']; ?></td>
                                                <td><?= $teacher['nom_utilis']; ?></td>
                                                <td><?= $teacher['prenom_utilis']; ?></td>
                                                <td><?= $teacher['date_de_naissance']; ?></td>
                                                <td><?= $teacher['adresse_utilis']; ?></td>
                                                <td><?= $teacher['n°_tlph']; ?></td>
                                                <td><?= $teacher['email']; ?></td>
                                                <td><?= $teacher['mot_de_passe']; ?></td>
                                                <td><?= $teacher['nom_classe']; ?></td>
                                                <td><?= $teacher['nom_matiere']; ?></td>
                                                <td>
                                                    <a href="teacher-view.php?id=<?= $teacher['id_utilis']; ?>" class="btn btn-info btn-sm">Voir</a>
                                                    <a href="teacher_edit.php?id=<?= $teacher['id_utilis']; ?>" class="btn btn-success btn-sm">Modifier</a>
                                                    <form action="code.php" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_teacher" value="<?= $teacher['id_utilis']; ?>" class="btn btn-danger btn-sm">Supprimer</button>
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
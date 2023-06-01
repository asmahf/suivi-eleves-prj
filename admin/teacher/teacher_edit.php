<?php
// if(!isset($_SESSION)) 
{
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>Modifier enseignant</title>
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
                            <h4> Modifier enseignant
                                <a href="teacher.php" class="btn btn-danger float-end">Retour</a>
                            </h4>
                        </div>
                        <div class="card-body">

                            <?php
                            if (isset($_GET['id'])) {
                                $teacher_id = mysqli_real_escape_string($con, $_GET['id']);
                                $query = "SELECT * FROM utilisateur WHERE (id_utilis='$teacher_id')AND (type_utilis='enseignant');";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    $teacher = mysqli_fetch_array($query_run);
                            ?>
                                    <form action="code.php" method="POST">
                                        <input type="hidden" name="teacher_id" value="<?= $teacher['id_utilis']; ?>">

                                        <div class="mb-3">
                                            <label>Nom</label>
                                            <input type="text" name="username" value="<?= $teacher['nom_utilis']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Prenom</label>
                                            <input type="text" name="firstname" value="<?= $teacher['prenom_utilis']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Date de naissance</label>
                                            <input type="date" name="date_of_birth" value="<?= $teacher['date_de_naissance']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Adresse</label>
                                            <input type="text" name="adresse" value="<?= $teacher['adresse_utilis']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Numero telephone</label>
                                            <input type="tel" name="num-telephone" value="<?= $teacher['n°_tlph']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label> Email</label>
                                            <input type="email" name="email" value="<?= $teacher['email']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Mot de passe</label>
                                            <input type="password" name="password" value="<?= $teacher['mot_de_passe']; ?>" class="form-control">
                                        </div>
                                        <div class=" mb-3">
                                            <label>Classes enseignées</label>
                                            <select name="classe[]" class="js-example-basic-multiple form-control" multiple="multiple">
                                                <?php
                                                $con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');
                                                $id_enseignant = $_GET['id'];
                                                // Préparer la requête SQL pour récupérer les classes avec leur ID d'enseignant associé, s'il y en a un
                                                $sql = "SELECT c.nom_classe, e.id_enseignant FROM classe c LEFT JOIN enseigner e 
                                            ON c.nom_classe = e.nom_classe AND e.id_enseignant = ?";
                                                $stmt = mysqli_prepare($con, $sql);
                                                mysqli_stmt_bind_param($stmt, 'i', $id_enseignant);
                                                mysqli_stmt_execute($stmt);
                                                // Récupérer les résultats de la requête SQL
                                                $result = mysqli_stmt_get_result($stmt);
                                                // Initialiser un tableau des classes sélectionnées pour l'enseignant
                                                $selected_classes = array();
                                                // Parcourir tous les résultats de la requête SQL
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    // Si l'ID de l'enseignant correspond à celui récupéré depuis la variable GET, ajouter la classe au tableau des classes sélectionnées
                                                    if ($row['id_enseignant'] == $id_enseignant) {
                                                        $selected_classes[] = $row['nom_classe'];
                                                    }
                                                ?>
                                                    <!-- Afficher une option pour chaque classe avec son nom comme valeur et son nom comme label -->
                                                    <option value="<?= $row['nom_classe']; ?>" <?php if (in_array($row['nom_classe'], $selected_classes)) echo 'selected'; ?>><?= $row['nom_classe']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Matiere enseigne</label>
                                            <input type="text" name="matiere" value="<?= $teacher['matiere_enseigne']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" name="update_teacher" class="btn btn-primary">
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
    </main>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
</body>

</html>
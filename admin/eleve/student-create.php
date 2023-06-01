<?php
// if(!isset($_SESSION)) 
{
    session_start();
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Ajouter eleve</title>
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
                            <h4>Ajouter eleve
                                <a href="index.php" class="btn btn-danger float-end">Retour</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST">

                                <div class="mb-3">
                                    <label>Nom *</label>
                                    <input type="text" name="nom_eleve" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Prenom *</label>
                                    <input type="text" name="prenom_eleve" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Date De Naissance * </label>
                                    <input type="date" name="date_naiss_eleve" class="form-control" required>
                                </div>

                                <div class="mb-3 ">
                                    <label>Sexe *</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sexe" value="garçon" checked required>
                                        <label class="form-check-label">Garçon</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sexe" value="fille" required>
                                        <label class="form-check-label">Fille</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Classe *</label>
                                    <select name="nom_classe" value="<?= $eleve['classe']; ?>" class=" form-control form-select" required>
                                        <option selected>veuillez choisir sa classe</option>
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
                                    <button type="submit" name="save_eleve" class="btn btn-primary">Enregistrer</button>
                                </div>

                            </form>
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
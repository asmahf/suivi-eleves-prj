<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>Ajouter enseignant</title>
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
                            <h4>Ajouter enseignant
                                <a href="teacher.php" class="btn btn-danger float-end">Retour</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST">

                                <div class="mb-3">
                                    <label>Nom *</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                                <div>
                                    <label>Prenom *</label>
                                    <input type="text" name="firstname" class="form-control" required>
                                </div>
                                <div>
                                    <label>Date de naissance *</label>
                                    <input type="date" name="date_of_birth" class="form-control" required>
                                </div>
                                <div>
                                    <label>Adresse *</label>
                                    <input type="text" name="adresse" class="form-control" required>
                                </div>
                                <div>
                                    <label>Numero telephone *</label>
                                    <input type="tel" name="num-telephone" class="form-control" required>
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <label> Email *</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Mot de passe *</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>

                                    <div class=" mb-3">
                                        <label>Classe enseigne * </label>
                                        <select name="classe[]" class=" js-example-basic-multiple form-control" multiple="multiple" required>

                                            <?php
                                            $con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');
                                            $name_classe = "SELECT nom_classe from `classe`";
                                            $name_classe_run = mysqli_query($con, $name_classe);
                                            if (mysqli_num_rows($name_classe_run)) {
                                                foreach ($name_classe_run as $row) {
                                            ?>
                                                    <option value=<?= $row['nom_classe']; ?>> <?= $row['nom_classe']; ?></option>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <option value=""> il n'y a pas de classes </option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Matiere enseigne *</label>
                                        <select name="matiere[]" class="js-example-basic-multiple form-control " multiple="multiple" required>

                                            <?php
                                            $con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');
                                            $name_subject = "SELECT nom_matiere from `matiere`";
                                            $name_subject_run = mysqli_query($con, $name_subject);
                                            if (mysqli_num_rows($name_subject_run)) {
                                                foreach ($name_subject_run as $row) {
                                            ?>
                                                    <option value=<?= str_replace(' ', '-', $row['nom_matiere']); ?>> <?= $row['nom_matiere']; ?></option>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <option value=""> il n'y a pas de matieres </option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" name="save_teacher" class="btn btn-primary">Enregistrer</button>
                                    </div>

                            </form>
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
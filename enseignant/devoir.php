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

    <title>Ajouter devoir</title>
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="container mt-5">
            <div class="card-body">
                <div class="form">
                    <form method="POST" action="devoir.php">
                        <div class=" mb-3">
                            <label for="matiere">Choisir une matiere:</label>
                            <select name="matiere" id="matiere" class="form-select">
                                <?php
                                $con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');
                                $id_enseignant = $_SESSION['user']->id_utilis; // à adapter selon votre contexte
                                // $id_enseignant = 160;
                                $sql = "SELECT m.nom_matiere FROM matiere m LEFT JOIN enseigner_matiere e ON m.nom_matiere = e.nom_matiere WHERE e.id_enseignant = ?";
                                $stmt = mysqli_prepare($con, $sql);
                                mysqli_stmt_bind_param($stmt, 'i', $id_enseignant);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <option value="<?= $row['nom_matiere']; ?>"><?= $row['nom_matiere']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                </div>
                <div class=" mb-3">
                    <label for="contenu_devoir">Contenu du devoir :</label>
                    <textarea class="form-control" id="contenu_devoir" name="contenu_devoir"></textarea>
                </div>
            </div>
            <div class=" mb-3">
                <label>Selectionner les classes concernées:</label>
                <select name="classe[]" class="js-example-basic-multiple form-select" multiple="multiple">
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
            <div class=" mb-3">
                <label for="delai_devoir">Date limite :</label><br>
                <input type="date" id="delai_devoir" name="delai_devoir">
            </div>
            <div>
                <input type="submit" name="submit_devoir" value="Ajouter le devoir" class="btn btn-primary ">
            </div>
        </div>
        </div>

        <?php



        // vérifier que le formulaire a été soumis
        if (isset($_POST['submit_devoir'])) {
            // récupérer les données soumises
            $nom_matiere = $_POST['matiere'];
            $contenu_devoir = $_POST['contenu_devoir'];
            $delai_devoir = $_POST['delai_devoir'];
            $nom_classe = $_POST['classe'];
            // $id_enseignant = $_SESSION['id_enseignant'];

            $eleves = array();
            foreach ($nom_classe as $classe) {
                // Récupération de la liste des élèves de la classe sélectionnée
                $sql_eleves = "SELECT id_eleve FROM eleve WHERE nom_classe = ?";
                $stmt_eleves = mysqli_prepare($con, $sql_eleves);
                mysqli_stmt_bind_param($stmt_eleves, 's', $classe);
                mysqli_stmt_execute($stmt_eleves);
                mysqli_stmt_store_result($stmt_eleves);
                mysqli_stmt_bind_result($stmt_eleves, $id_eleve);
                // Ajouter les élèves à la liste
                while (mysqli_stmt_fetch($stmt_eleves)) {
                    $eleves[] = $id_eleve;
                }
            }


            // insérer le devoir pour chaque élève
            foreach ($eleves as $id_eleve) {
                // récupérer l'ID de la fiche de suivi de l'élève
                $sql_fiche = "SELECT id_fiche FROM fiche_eleve WHERE id_eleve = $id_eleve";
                $result_fiche = mysqli_query($con, $sql_fiche);
                $fiche_eleve = mysqli_fetch_assoc($result_fiche);
                $id_fiche = $fiche_eleve['id_fiche'];

                // insérer le devoir 
                $sql_devoir = "INSERT INTO devoir (contenu_devoir, delai_devoir, id_enseignant, id_fiche,nom_matiere) VALUES (?, ?, ?, ?,?)";
                $stmt_devoir = mysqli_prepare($con, $sql_devoir);

                // lier les paramètres à la requête préparée
                mysqli_stmt_bind_param($stmt_devoir, 'ssiis', $contenu_devoir, $delai_devoir, $id_enseignant, $id_fiche, $nom_matiere);
                mysqli_stmt_execute($stmt_devoir);

                // vérifier si l'insertion a réussi
                if (mysqli_affected_rows($con) > 0) {
                    $homework_added = true;
                }
            }

            // afficher le message approprié en fonction du résultat de l'opération
            if ($homework_added) {
                echo "Le devoir a été ajouté avec succès.";
            } else {
                echo "Une erreur s'est produite. Veuillez réessayer plus tard.";
            }
        }

        // fermer  la connexion à la base de données
        mysqli_close($con);
        ?>
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
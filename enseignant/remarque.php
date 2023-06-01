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

    <title>Donner remarque</title>
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="container mt-3">

            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h4> Donner des remarques
                                <a href="index.php" class="btn btn-danger float-end">Retour</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <form method="GET" action="remarque.php">
                                    <label for="classe">Choisir une classe :</label>
                                    <select name="classe" id="classe">
                                        <?php
                                        $con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');
                                        $id_enseignant = $_SESSION['user']->id_utilis;


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
                            <div class="mb-4">
                                <button type="submit" name="showlist" class="btn btn-primary btn-sm">Afficher la liste des élèves</button>
                            </div>
                            <?php

                            if (isset($_GET['showlist'])) {
                                // Récupérer l'enseignant et la classe sélectionnée depuis l'URL
                                $nom_classe = $_GET['classe'];


                                // Récupération de la liste des élèves de la classe sélectionnée
                                $sql = "SELECT id_eleve, nom_eleve, prenom_eleve FROM eleve WHERE nom_classe = ?";
                                $stmt = mysqli_prepare($con, $sql);
                                mysqli_stmt_bind_param($stmt, 's', $nom_classe);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_store_result($stmt);
                                $eleve = mysqli_stmt_bind_result($stmt, $id_eleve, $nom_eleve, $prenom_eleve);

                                // Création de la liste déroulante des élèves
                                echo '<div class="mb-3">';

                                echo '<form method="GET" action="remarque.php">';
                                echo '  <label for="classe">Choisir un eleve :</label>';
                                echo "<select name='id_eleve'>";
                                while (mysqli_stmt_fetch($stmt)) {
                                    echo "<option value='" . $id_eleve . "'>" . $nom_eleve . " " . $prenom_eleve . "</option>";
                                }
                                echo '</select>';
                                echo '</div>';
                                echo ' <div class="mb-3">';
                                echo '<button type="submit" name="remarque" class="btn btn-primary btn-sm">Ecrire remarque</button>';
                                echo '</div>';
                                echo ' </form>';
                            }

                            ?>
                            </form>

                        </div>
                    </div>
                </div>
            </div>






            <?php
            if (isset($_GET['remarque'])) {
                $eleve_id = $_GET['id_eleve'];
                $sql = "SELECT * FROM eleve WHERE id_eleve = $eleve_id";
                $result = mysqli_query($con, $sql);
                $eleve = mysqli_fetch_assoc($result);

                // afficher le formulaire de saisie de la remarque si un élève a été sélectionné
                echo "<div class='container mt-4'>";
                echo "<div class='row'>";
                echo "<div class='col-md-6 '>";
                echo " <h4 class='text-left'>Ajouter une remarque pour <b>" . $eleve['nom_eleve'] . " " . $eleve['prenom_eleve'] . "</b></h4>";
                echo " <form action='remarque.php' method='post'>";
                echo "<input type='hidden' name='eleve_id' value='<?php echo $eleve_id; ?>'>";
                echo "<div class='form-group'>";
                echo "<textarea name='remarque' class='form-control' rows='7'></textarea>";
                echo "</div>";
                echo "<div class=' mt-3'>";
                echo " <input type='submit' name='submit_remarque' class='btn btn-primary' value='Envoyer'>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
            <?php
            if (isset($_POST['submit_remarque'])) {
                $eleve_id = $_POST['eleve_id'];
                $remarque = $_POST['remarque'];
                // $id_enseignant = 160;
                // récupérer l'ID de la fiche de suivi de l'élève
                $sql = "SELECT id_fiche FROM fiche_eleve WHERE id_eleve = $eleve_id";
                $result = mysqli_query($con, $sql);
                $fiche_eleve = mysqli_fetch_assoc($result);
                $id_fiche = $fiche_eleve['id_fiche'];

                // insérer la remarque dans la table
                $sql = "INSERT INTO remarques (contenu_remarque, id_fiche,id_enseignant) VALUES (?, ?,$id_enseignant)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, 'si', $remarque, $id_fiche);
                mysqli_stmt_execute($stmt);

                // vérifier si l'insertion a réussi
                if (mysqli_affected_rows($con) > 0) {
                    echo "La remarque a été ajoutée avec succès.";
                } else {
                    echo "Une erreur s'est produite. Veuillez réessayer plus tard.";
                }
            }
            ?>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
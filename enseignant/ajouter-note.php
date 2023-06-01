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

    <title>Note evaluation</title>
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <main>

        <div class="container mt-4">

            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h4> Ajouter des notes<a href="index.php" class="btn btn-danger float-end">Retour</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="ajouter-note.php">
                                <?php
                                $con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');
                                $id_enseignant = $_SESSION['user']->id_utilis;
                                $sql = "SELECT c.nom_classe FROM classe c LEFT JOIN enseigner e ON c.nom_classe = e.nom_classe WHERE e.id_enseignant = ?";
                                $stmt = mysqli_prepare($con, $sql);
                                mysqli_stmt_bind_param($stmt, 'i', $id_enseignant);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                $no_class = true;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($row['nom_classe'][0] != "1" && $row['nom_classe'][0] != "2") {
                                        if ($no_class) {
                                            echo '<div class="mb-3">';
                                            echo ' <label for="classe">Choisir une classe :</label>';
                                            echo ' <select name="classe" id="classe" class="form-select w-25 my-1">';
                                        }
                                        $no_class = false;
                                ?>
                                        <option value="<?= $row['nom_classe']; ?>"><?= $row['nom_classe']; ?></option>
                                <?php
                                    }
                                }

                                if ($no_class) {
                                    echo '<h3 class="text-secondary">Vous n’êtes pas concernées par cette option</h3>';
                                    echo '</form></div></div></div></div> </div></main></div></body></html>';
                                    die;
                                } else {
                                    echo '</select>';
                                    echo '</div>';
                                }
                                ?>


                                <div class="mb-3">
                                    <form method="GET" action="ajouter-note.php">
                                        <label for="matiere">Choisir une matiere :</label>
                                        <select name="matiere" id="matiere" class="form-select w-25">
                                            <?php
                                            $matiere_essentiel_list = array("Langue Arabe", "Mathématiques", "Langue française", "Langue anglaise");
                                            // $con = new mysqli('localhost', 'Asma', '232300', 'suivieleve');
                                            // $id_enseignant = $_SESSION['user']->id_utilis; 
                                            $sql = "SELECT m.nom_matiere FROM matiere m LEFT JOIN enseigner_matiere e ON m.nom_matiere = e.nom_matiere WHERE e.id_enseignant = ?";
                                            $stmt = mysqli_prepare($con, $sql);
                                            mysqli_stmt_bind_param($stmt, 'i', $id_enseignant);
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                if (in_array($row['nom_matiere'], $matiere_essentiel_list)) {
                                            ?>
                                                    <option value="<?= $row['nom_matiere']; ?>"><?= $row['nom_matiere']; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" name="showlist" class="btn btn-primary ">Afficher la liste des élèves</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_GET['showlist'])) {
                $id_enseignant = $_SESSION['user']->id_utilis;
                $nom_matiere = $_GET['matiere'];
                $nom_classe = $_GET['classe'];

                // Vérifier que l'enseignant enseigne bien cette classe
                $sql = "SELECT * FROM enseigner WHERE id_enseignant = ? AND nom_classe = ?";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, 'is', $id_enseignant, $nom_classe);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 0) {
                    echo "Vous n'êtes pas autorisé à accéder à cette classe.";
                    exit;
                }
                // Vérifier que l'enseignant enseigne bien cette classe
                $sql = "SELECT * FROM enseigner_matiere WHERE id_enseignant = ? AND nom_matiere = ?";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, 'is', $id_enseignant,  $nom_matiere);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 0) {
                    echo "Vous n'êtes pas autorisé à accéder à cette matiere.";
                    exit;
                }

                // Récupérer la liste des élèves pour cette classe
                $sql = "SELECT * FROM eleve WHERE nom_classe = ?";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, 's', $nom_classe);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                // Afficher la liste des élèves

                echo '<div class="mt-5">';
                echo "<h3>La liste des élèves de la classe <b> $nom_classe </b>:</h3>";
                echo '<form method="POST" action="ajouter-note.php">';
                echo '<table class="table  table-bordered">';
                echo '<thead><tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col" >Date de naissance</th>
            <th scope="col">Note</th>
            
            </tr></thead>';
                echo '<tbody>';
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<th scope="row">' . $i . '</th>';
                    echo '<td>' . $row['nom_eleve'] . '</td>';
                    echo '<td>' . $row['prenom_eleve'] . '</td>';
                    echo '<td>' . $row['date_naiss_eleve'] . '</td>';
                    echo '<td><input type="number" name="notes[' . $row['id_eleve'] . ']" min="0" max="10" step="0.5" value="' . (isset($row['note']) ? $row['note'] : '') . '"></td>';
                    echo '<input type="hidden" name="id_eleve[' . $row['id_eleve'] . ']" value="' . $row['id_eleve'] . '">';
                    echo '<input type="hidden" name="nom_matiere" value="' . $nom_matiere . '">';


                    echo '</tr>';
                    $i++;
                }
                echo '</tbody>';
                echo '</table>';
                echo '<input type="submit" class="btn btn-success" name="submit_notes" value="Enregistrer les notes">';
                echo '</form>';
                echo ' </div>';
            }

            if (isset($_POST['submit_notes'])) {
                // récupérer les données soumises
                $id_eleves = $_POST['id_eleve'];
                $notes = $_POST['notes'];
                $id_fiches = array();
                $id_enseignant = $_SESSION['user']->id_utilis;
                $nom_matiere = $_POST['nom_matiere'];

                // $id_enseignant = 160;
                // vérifier que toutes les données requises ont été soumises
                if (empty($id_eleves) || empty($notes)) {
                    echo "Tous les champs sont obligatoires.";
                    exit;
                }



                // préparer la requête d'insertion
                $sql = "INSERT INTO note ( valeur_note,nom_matiere,id_enseignant,id_fiche) VALUES (?, ?,?,?)";
                $stmt = mysqli_prepare($con, $sql);

                $note_added = 0;
                // pour chaque élève, récupérer l'ID de la fiche de suivi et insérer la note
                foreach ($id_eleves as $index => $id_eleve) {
                    // récupérer l'ID de la fiche de suivi
                    $sql = "SELECT id_fiche FROM fiche_eleve WHERE id_eleve = ?";
                    $stmt_id_fiche = mysqli_prepare($con, $sql);
                    mysqli_stmt_bind_param($stmt_id_fiche, 'i', $id_eleve);
                    mysqli_stmt_execute($stmt_id_fiche);
                    mysqli_stmt_store_result($stmt_id_fiche);
                    mysqli_stmt_bind_result($stmt_id_fiche, $id_fiche);
                    mysqli_stmt_fetch($stmt_id_fiche);
                    array_push($id_fiches, $id_fiche);
                    // echo "\n L'ID de fiche est : " . $id_fiche . "";


                    // insérer la note
                    $note = $notes[$index];
                    mysqli_stmt_bind_param($stmt, 'dsii', $note, $nom_matiere, $id_enseignant, $id_fiche);
                    mysqli_stmt_execute($stmt);


                    // vérifier si l'insertion a réussi
                    if (mysqli_affected_rows($con) > 0) {
                        $note_added = 1;
                    }
                }

                //afficher le message approprié en fonction du résultat de l'opération
                if ($note_added == 1) {

                    echo '<div class="alert alert-success" role="alert">
                        Les notes ont été enregistrées avec succès.
                </div>';
                } else if ($note_added == 0) {

                    echo  '<div class="alert alert-danger" role="alert">
                    Une erreur est produite. Veuillez réessayer plus tard.
                  </div>';
                }

                // fermer la connexion à la base de données
                mysqli_close($con);
            }

            ?>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
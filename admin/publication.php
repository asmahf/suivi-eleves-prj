<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../config/database.php';
?>


<!DOCTYPE html>
<html>

<head>
    <title>Gestion des publications</title>
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include './sidebar.php'; ?>
    <main>
        <h1 class="text-center mb-4">Gestion des publications</h1>

        <?php


        // Vérifier si le formulaire d'ajout a été soumis
        if (isset($_POST["ajouterPublication"])) {
            $id_admin = $_SESSION['user']->id_utilis;
            // Récupérer les données du formulaire
            $typePublication = $_POST["typePublication"];
            $contenuPublication = $_POST["contenuPublication"];
            $datePublication = date('Y-m-d');
            // Requête pour insérer la publication dans la table
            $sql = "INSERT INTO publication (type_pub, contenu_pub,date,id_admin) VALUES (?,?,?, ?)";
            $stmt = mysqli_prepare($con, $sql);

            // Lier le paramètre au contenu du fichier
            mysqli_stmt_bind_param($stmt, 'sssi', $typePublication, $contenuPublication, $datePublication, $id_admin);
            if (mysqli_stmt_execute($stmt)) {
                echo "La publication a été ajoutée avec succès.";
            } else {
                echo "Erreur lors de l'ajout de la publication: ";
            }
        }
        // Vérifier si une publication doit être supprimée
        if (isset($_GET["supprimerPublication"])) {
            $idPublication = $_GET["supprimerPublication"];

            // Requête pour supprimer la publication de la table
            $sql = "DELETE FROM publication WHERE id_pub = '$idPublication'";

            if ($con->query($sql) === TRUE) {
                echo "La publication a été supprimée avec succès.";
            } else {
                echo "Erreur lors de la suppression de la publication: " . $con->error;
            }
        }
        ?>

        <div class="card mb-5 mx-3 shadow rounded">

            <h3 class="card-header">Ajouter une publication</h3>
            <form class='card-body' method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <label class="h5 card-text" for="typePublication">Type de publication:</label>
                <select class="form-select w-25 mb-3" name="typePublication" required>
                    <option value="annonce">Annonce</option>
                    <option value="activite">Activité</option>

                </select>

                <label class="h5 card-text" for="contenuPublication">Contenu de la publication:</label><br>
                <textarea class="form-control w-75 mb-4" name="contenuPublication" rows="4" cols="50" required></textarea>

                <input class="btn btn-primary" type="submit" name="ajouterPublication" value="Ajouter">
            </form>
        </div>

        <div class="card mx-3 shadow rounded">

            <h3 class="card-header">Publications existantes</h3>

            <?php
            // Récupérer toutes les publications de la table
            $sql = "SELECT * FROM publication WHERE type_pub  IN ('annonce', 'activite')";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                $hr = 0;
                echo "<div class=' py-3 '>";

                while ($row = $result->fetch_assoc()) {
                    $idPublication = $row["id_pub"];
                    $typePublication = $row["type_pub"];
                    $contenuPublication = $row["contenu_pub"];
                    if ($hr != 0) {
                        echo "<hr class='border border-1 opacity-100'>";
                    }

                    echo "<div class='container px-4'>";
                    echo "<div class='card-text pb-1'><strong>Type:</strong> $typePublication</div>";
                    echo "<div class='card-text pb-1'><strong>Contenu:</strong> $contenuPublication</div>";
                    echo "<a class='btn btn-danger mt-2' href='" . $_SERVER["PHP_SELF"] . "?supprimerPublication=$idPublication'>Supprimer</a>";
                    echo "</div>";
                    $hr = 1;
                }
                echo "</div>";

                $hr = 0;
            } else {
                echo "Aucune publication n'a été trouvée.";
            }

            // Fermeture de la connexion
            $con->close();

            ?>
        </div>

    </main>
</body>

</html>
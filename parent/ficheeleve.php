<!DOCTYPE html>
<html>

<head>
    <title>Liste déroulante des enfants</title>
    <style>
        .select-list {
            width: 200px;
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .select-list option {
            font-size: 14px;
            color: #333;
        }
    </style>
</head>

<body>
    <main>
        <?php
        // Connexion à la base de données
        $con = mysqli_connect("localhost", "Asma", "232300", "suivieleve");

        // Vérification de la connexion
        if (!$con) {
            die("Erreur de connexion à la base de données : " . mysqli_connect_error());
        }

        // Récupération de l'ID du parent connecté (vous devrez adapter cette partie selon votre système d'authentification)
        $id_parent = 225;

        // Requête pour récupérer les enfants du parent connecté
        $query = "SELECT id_eleve, prenom_eleve, nom_eleve FROM eleve WHERE id_parent = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_parent);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Construction de la liste déroulante
        echo '<select name="fiche_eleve" class="select-list">';
        while ($row = mysqli_fetch_assoc($result)) {
            $prenom = $row['prenom_eleve'];
            $nom = $row['nom_eleve'];
            echo '<option value="' . $row['id_eleve'] . '">' . $prenom . ' ' . $nom . '</option>';
        }
        echo '</select>';

        // Fermeture de la connexion à la base de données
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        ?>
    </main>
</body>

</html>
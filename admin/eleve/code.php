<?php
if (!isset($_SESSION)) {
    session_start();
}
require './dbcon.php';

if (isset($_POST['delete_eleve'])) {
    $id_eleve = mysqli_real_escape_string($con, $_POST['delete_eleve']);

    // Suppression de l'entrée correspondante dans la table "fiche_eleve"
    $query_fiche = "DELETE FROM fiche_eleve WHERE id_eleve = ?";
    $stmt_fiche = mysqli_prepare($con, $query_fiche);
    mysqli_stmt_bind_param($stmt_fiche, "i", $id_eleve);

    if (mysqli_stmt_execute($stmt_fiche)) {

        // Suppression de l'élève de la table "eleve" avec l'id spécifié
        $query = "DELETE FROM eleve WHERE id_eleve = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_eleve);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "L'eleve est supprimé ";
            header("Location: index.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression de la fiche de l'élève";
            header("Location: index.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "l'eleve n'est pas supprimé ";
        header("Location: index.php");
        exit(0);
    }
}

if (isset($_POST['update_eleve'])) {
    $id_eleve = mysqli_real_escape_string($con, $_POST['id_eleve']);
    $nom_eleve = mysqli_real_escape_string($con, $_POST['nom_eleve']);
    $prenom_eleve = mysqli_real_escape_string($con, $_POST['prenom_eleve']);
    $date_naiss_eleve = mysqli_real_escape_string($con, $_POST['date_naiss_eleve']);
    $sexe = mysqli_real_escape_string($con, $_POST['sexe']);
    $nom_classe = mysqli_real_escape_string($con, $_POST['nom_classe']);
    $code_eleve = mysqli_real_escape_string($con, $_POST['code_eleve']);

    $query = "UPDATE eleve SET nom_eleve='$nom_eleve', prenom_eleve='$prenom_eleve',date_naiss_eleve='$date_naiss_eleve',sexe='$sexe', nom_classe='$nom_classe',code_eleve='$code_eleve' WHERE  id_eleve='$id_eleve'   ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "L'eleve est mis à jour avec succès";
        header("Location: student-create.php");
        exit(0);
    } else {
        $_SESSION['message'] = "les informations d'eleve ne sont pas mises à jour";
        header("Location: student-create.php");
        exit(0);
    }
}


if (isset($_POST['save_eleve'])) {
    $nom_eleve = mysqli_real_escape_string($con, $_POST['nom_eleve']);
    $prenom_eleve = mysqli_real_escape_string($con, $_POST['prenom_eleve']);
    $date_naiss_eleve = mysqli_real_escape_string($con, $_POST['date_naiss_eleve']);
    $formattedDate = date("dmY", strtotime($date_naiss_eleve));
    $sexe = mysqli_real_escape_string($con, $_POST['sexe']);
    $nom_classe = mysqli_real_escape_string($con, $_POST['nom_classe']);
    $code = $nom_eleve . "." . $prenom_eleve . $formattedDate;
    $code_eleve = mysqli_real_escape_string($con, $code);
    $query = "INSERT INTO eleve (nom_eleve,prenom_eleve,date_naiss_eleve,sexe,nom_classe,code_eleve) VALUES ('$nom_eleve','$prenom_eleve','$date_naiss_eleve','$sexe','$nom_classe','$code_eleve')";


    if (mysqli_query($con, $query)) {
        // Récupération de l'ID de l'élève inséré
        $id_eleve = mysqli_insert_id($con);

        // Insertion de l'ID de l'élève dans la table "fiche_eleve"
        $query_fiche = "INSERT INTO fiche_eleve (id_eleve) VALUES ('$id_eleve')";


        if (mysqli_query($con, $query_fiche)) {
            $_SESSION['message'] = "Eleve créé avec succès";
            header("Location: student-create.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Erreur lors de la création de la fiche de l'élève";
            header("Location: student-create.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Eleve non créé";
        header("Location: student-create.php");
        exit(0);
    }
}

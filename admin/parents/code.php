<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../database.php';
if (isset($_POST['delete_parent'])) {
    $id_parent = mysqli_real_escape_string($con, $_POST['delete_parent']);

    // Suppression de l'entrée correspondante dans la table "fiche_eleve"
    $query_fiche =  "UPDATE fiche_eleve SET id_parent=NULL WHERE  id_parent=? ";
    $stmt_fiche = mysqli_prepare($con, $query_fiche);
    mysqli_stmt_bind_param($stmt_fiche, "i", $id_parent);
    mysqli_stmt_execute($stmt_fiche);
    // Suppression de l'entrée correspondante dans la table "eleve"
    $query_eleve =  "UPDATE eleve SET id_parent=NULL WHERE  id_parent=? ";
    $stmt_eleve = mysqli_prepare($con, $query_eleve);
    mysqli_stmt_bind_param($stmt_eleve, "i", $id_parent);
    if (mysqli_stmt_execute($stmt_eleve)) {

        // Suppression de l'élève de la table "eleve" avec l'id spécifié
        $query = "DELETE  FROM utilisateur WHERE id_utilis= ? ";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_parent);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Le parent est supprimé ";
            header("Location: index.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression de la fiche de l'élève";
            header("Location: index.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "le parent n'est pas supprimé ";
        header("Location: index.php");
        exit(0);
    }
}

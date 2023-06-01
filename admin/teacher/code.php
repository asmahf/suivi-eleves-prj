<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../database.php';

if (isset($_POST['delete_teacher'])) {
    $teacher_id = mysqli_real_escape_string($con, $_POST['delete_teacher']);

    $query = "DELETE FROM utilisateur WHERE id_utilis='$teacher_id'AND type_utilis='enseignant'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "L'enseignant est supprimé avec succès";
        header("Location: teacher.php");
        exit(0);
    } else {
        $_SESSION['message'] = "L'enseignant n'est pas supprimé avec succès";
        header("Location: teacher.php");
        exit(0);
    }
}

if (isset($_POST['update_teacher'])) {
    $teacher_id = mysqli_real_escape_string($con, $_POST['teacher_id']);

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $date_of_birth = mysqli_real_escape_string($con, $_POST['date_of_birth']);
    $adress = mysqli_real_escape_string($con, $_POST['adresse']);
    $phone = mysqli_real_escape_string($con, $_POST['num-telephone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $classes_selectionnees = $_POST['classe'];
    $matiere = mysqli_real_escape_string($con, $_POST['matiere']);

    // Commencer une transaction
    mysqli_begin_transaction($con);

    // Mettre à jour les informations de l'enseignant
    $query_update_teacher = "UPDATE `utilisateur` SET `nom_utilis`='$username', `prenom_utilis`='$firstname', `date_de_naissance`='$date_of_birth', 
    `adresse_utilis`='$adress', `n°_tlph`='$phone' , `email`='$email', `mot_de_passe`='$password', `matiere_enseigne`='$matiere' WHERE id_utilis='$teacher_id' ";
    $query_run_update_teacher = mysqli_query($con, $query_update_teacher);

    // Supprimer toutes les entrées pour cet enseignant dans la table enseigner
    $query_delete_enseigner = "DELETE FROM enseigner WHERE id_enseignant='$teacher_id'";
    $query_run_delete_enseigner = mysqli_query($con, $query_delete_enseigner);

    // Insérer les nouvelles entrées pour cet enseignant dans la table enseigner
    foreach ($classes_selectionnees as $classe) {
        $query_insert_enseigner = "INSERT INTO enseigner (id_enseignant, nom_classe) VALUES ('$teacher_id', '$classe')";
        $query_run_insert_enseigner = mysqli_query($con, $query_insert_enseigner);
    }

    // Valider la transaction
    if ($query_run_update_teacher && $query_run_delete_enseigner && $query_run_insert_enseigner) {
        mysqli_commit($con);
        $_SESSION['message'] = "L'enseignant est mis à jour avec succès";
        header("Location: teacher.php");
        exit(0);
    } else {
        mysqli_rollback($con);
        $_SESSION['message'] = "les informations d'enseignant ne sont pas mises à jour ";
        header("Location: teacher.php");
        exit(0);
    }
}


if (isset($_POST['save_teacher'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $date_of_birth = mysqli_real_escape_string($con, $_POST['date_of_birth']);
    $adress = mysqli_real_escape_string($con, $_POST['adresse']);
    $phone = mysqli_real_escape_string($con, $_POST['num-telephone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $matieres =  $_POST['matiere'];
    $classes =  $_POST['classe'];



    // Prépare la requête d'insertion avec des paramètres
    $insert_user_query = "INSERT INTO `utilisateur`( `nom_utilis`, `prenom_utilis`, `date_de_naissance`, `adresse_utilis`, `n°_tlph`, `email`, `mot_de_passe`,`type_utilis` )
    VALUES(?, ?, ?,?,?,?, ?, 'enseignant'); ";

    // $query_run = mysqli_query($con, $query);
    $insert_user_stmt = mysqli_prepare($con, $insert_user_query);
    // Lie les paramètres aux variables
    mysqli_stmt_bind_param($insert_user_stmt, "sssssss", $username, $firstname, $date_of_birth, $adress, $phone, $email, $password);


    // Exécute la requête d'insertion

    if (mysqli_stmt_execute($insert_user_stmt)) {
        $enseignant_id = mysqli_insert_id($con);

        // Prépare la requête d'insertion pour la table 'enseigner'
        $insert_enseigner_query = "INSERT INTO `enseigner` (`id_enseignant`, `nom_classe`) VALUES (?, ?)";
        $insert_enseigner_stmt = mysqli_prepare($con, $insert_enseigner_query);
        // echo " classe: ", $classe[0], " ";
        if ($classes) {

            foreach ($classes as $classe) {
                // Lie les paramètres aux variables
                mysqli_stmt_bind_param($insert_enseigner_stmt, "is", $enseignant_id, $classe);

                // echo " classelist: ", $classeliste, " ";
                // echo " classe: ", gettype($classe), " ";
                mysqli_stmt_execute($insert_enseigner_stmt);
            }
        }

        // Prépare la requête d'insertion pour la table 'enseigner_matiere'
        $insert_enseigner_matiere_query = "INSERT INTO `enseigner_matiere` (`id_enseignant`, `nom_matiere`) VALUES (?, ?)";
        $insert_enseigner_matiere_stmt = mysqli_prepare($con, $insert_enseigner_matiere_query);

        if ($matieres) {

            foreach ($matieres as $matiere) {
                // Lie les paramètres aux variables
                mysqli_stmt_bind_param($insert_enseigner_matiere_stmt, "is", $enseignant_id,  str_replace('-', ' ', $matiere));
                // echo "id_enseignant", $enseignant_id;
                // echo " matierelist: ", $matiere, " ";

                mysqli_stmt_execute($insert_enseigner_matiere_stmt);
            }

            // Insère les valeurs dans la table 'enseigner' pour chaque classe sélectionnée

            $_SESSION['message'] = "Enseignant créé avec succès";
            header("Location: add-teacher.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Enseignant non créé";
        header("Location: add-teacher.php");
        exit(0);
    }
}

<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../config/database.php';

if (isset($_POST['submit_notes'])) {
    // récupérer les données soumises
    $id_eleves = $_POST['id_eleve'];
    $notes = $_POST['notes'];
    $id_fiches = array();
    $id_enseignant = $_SESSION['user']->id_utilis;
    // vérifier que toutes les données requises ont été soumises
    if (empty($id_eleves) || empty($notes)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }



    // préparer la requête d'insertion
    $sql = "INSERT INTO evaluation15jrs (id_fiche, note,date_evaluation,id_enseignant) VALUES (?, ?,NOW(),$id_enseignant)";
    $stmt = mysqli_prepare($con, $sql);
    $evaluation_effectue = 0;

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


        // vérifier si la dernière évaluation date de plus de 15 jours
        $sql = "SELECT date_evaluation FROM evaluation15jrs WHERE id_fiche = ? ORDER BY date_evaluation DESC LIMIT 1";
        $stmt_last_evaluation_date = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt_last_evaluation_date, 'i', $id_fiche);
        mysqli_stmt_execute($stmt_last_evaluation_date);
        mysqli_stmt_store_result($stmt_last_evaluation_date);
        mysqli_stmt_bind_result($stmt_last_evaluation_date, $last_evaluation_date);
        mysqli_stmt_fetch($stmt_last_evaluation_date);
        $evaluation_possible = empty($last_evaluation_date) || strtotime($last_evaluation_date) + (15 * 24 * 60 * 60) <= time();
        if ($evaluation_possible) {
            // insérer la note
            $note = $notes[$index];
            mysqli_stmt_bind_param($stmt, 'id', $id_fiche, $note);
            mysqli_stmt_execute($stmt);
            // vérifier si l'insertion a réussi
            if (mysqli_affected_rows($con) > 0) {
                $evaluation_effectue = 1;
            }
        } else {
            $evaluation_effectue = 2;
            echo "La dernière évaluation pour cette fiche date de moins de 15 jours.";
        }
    }

    //afficher le message approprié en fonction du résultat de l'opération
    if ($evaluation_effectue == 1) {
        echo "Les notes ont été enregistrées avec succès.";
    } else if ($evaluation_effectue == 0) {
        echo "Une erreur s'est produite. Veuillez réessayer plus tard.";
    }

    // fermer la connexion à la base de données
    mysqli_close($con);
}

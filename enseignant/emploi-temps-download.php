<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../config/database.php';


// if (isset($_GET['download'])) {
if (isset($_GET['id_pub'])) {

    // // Get the PDF ID from the request (e.g., query parameter or form input)
    $id_pub = $_GET['id_pub'];
    $id_admin = $_SESSION['user']->id_utilis;

    $type_pub = 'emplois_du_temps';

    // Préparer la requête d'insertion avec un paramètre pour le contenu du fichier
    $selectQuery = "SELECT  fichier_emploi FROM publication  WHERE id_pub = ? AND type_pub = ?";
    $stmt = mysqli_prepare($con, $selectQuery);

    // Lier le paramètre au contenu du fichier
    mysqli_stmt_bind_param($stmt, 'is', $id_pub, $type_pub);
    // Exécuter la requête d'insertion
    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_bind_result($stmt,  $fileContent);

        // Fetch the result
        if (mysqli_stmt_fetch($stmt)) {
            // // Set the appropriate headers for PDF download
            // header("Content-type: application/pdf");
            // header("Content-Disposition: attachment; filename=pdf_file.pdf");

            // Clean the output buffer
            ob_clean();

            // Set the appropriate headers for PDF display
            header("Content-type: application/pdf");
            header("Content-Disposition: attachment; filename=pdf_file.pdf");

            // Output the PDF file data
            echo $fileContent;
            exit;
        } else {
            echo "PDF file not found.";
        }
    } else {
        echo "Erreur lors de la recherche du fichier PDF ";
    }
    mysqli_stmt_close($stmt);


    // Fermer la connexion à la base de données
    $con->close();
}

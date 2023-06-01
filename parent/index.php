<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->type_utilis === "parent") {
    } else {
        header("location:http://localhost/suivi-eleves-prj/login-parent.php", true);
        die("");
    }
} else {
    header("location:http://localhost/suivi-eleves-prj/login-parent.php", true);
    die("");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>Parent</title>
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <!-- Main content -->
    <main class="main-content">
        <!-- Contenu de la page -->
    </main>
    </div>
</body>

</html>
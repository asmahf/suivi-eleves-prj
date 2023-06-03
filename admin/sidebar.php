<!-- <?php
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']->type_utilis === "admin") {
                // echo 'Welcome ' .$_SESSION['user']->prenom_utilis ;
            } else {
                header("location:http://localhost/suivi-eleves-prj/login-admin.php", true);
                die("");
            }
        } else {
            header("location:http://localhost/suivi-eleves-prj/login-admin.php", true);
            die("");
        }

        if (isset($_GET['logout']) && $_GET['logout'] === 'true') {

            //   réinitialiser les données utilisateur et détruire la session
            session_unset(); // Réinitialise toutes les variables de session
            session_destroy(); // Détruit la session actuelle
            // Redirigez l'utilisateur vers la page de connexion ou une autre page appropriée
            header("Location:../login-admin.php");
            exit; // Assurez-vous de quitter le script après la redirection
        }
        ?> -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="../../../../../../suivi-eleves-prj/css/style.css"> -->
    <title>admin</title>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidenav">
        <div class="sidenav-container">

            <div class="sidenav__close-icon">
                <i class="fas fa-times sidenav__brand-close"></i>
            </div>
            <div class="profile">
                <!-- <img src="chemin/vers/la/photo_de_profil.png" alt="Photo de profil"> -->
                <!-- <p>Username</p> -->
                <i class="fa-sharp fa-solid fa-circle-user"></i>
                <p><?php echo $_SESSION['user']->nom_utilis . " " . $_SESSION['user']->prenom_utilis; ?></p>
            </div>

            <nav>
                <ul class="sidenav__list">
                    <li class="sidenav__list-item"><a href="../../../suivi-eleves-prj/admin/acceuil.php"> Acceuil</a></li>

                    <li class="sidenav__list-item"><a href="../../../suivi-eleves-prj/admin/eleve/index.php" class="sidebar-link">Eleves</a></li>
                    <li class="sidenav__list-item"><a href="../../../suivi-eleves-prj/admin/teacher/teacher.php" class="sidebar-link">Enseignants</a></li>
                    <li class="sidenav__list-item"><a href="../../../suivi-eleves-prj/admin/parents/index.php" class="sidebar-link">Parents</a></li>
                    <li class="sidenav__list-item"><a href="../../../suivi-eleves-prj/admin/publication.php" class="sidebar-link">Publication</a></li>
                    <li class="sidenav__list-item"><a href="../../../suivi-eleves-prj/admin/ajouter-emploi-temps.php" class="sidebar-link">Emploi du temps</a></li>

                </ul>
            </nav>

            <div class="logout">
                <a href="?logout=true">Déconnexion</a>

            </div>
        </div>

    </aside>

</body>

</html>
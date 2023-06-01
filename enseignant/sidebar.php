<!-- <?php
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']->type_utilis === "enseignant") {
            } else {
                header("location:http://localhost/suivi-eleves-prj/login-teacher.php", true);
                die("");
            }
        } else {
            header("location:http://localhost/suivi-eleves-prj/login-teacher.php", true);
            die("");
        }

        if (isset($_GET['logout']) && $_GET['logout'] === 'true') {

            //   réinitialiser les données utilisateur et détruire la session
            session_unset(); // Réinitialise toutes les variables de session
            session_destroy(); // Détruit la session actuelle
            // Redirigez l'utilisateur vers la page de connexion ou une autre page appropriée
            header("Location: ../login-teacher.php");
            exit; // Assurez-vous de quitter le script après la redirection
        }
        ?> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Sidebar</title>
</head>

<body>

    <aside class="sidenav">
        <div class="sidenav-container">

            <div class="sidenav__close-icon">
                <i class="fas fa-times sidenav__brand-close"></i>
            </div>
            <div class="profile">
                <!-- <img src="chemin/vers/la/photo_de_profil.png" alt="Photo de profil"> -->
                <!-- <p>Username</p> -->
                <i class="fa-sharp fa-solid fa-circle-user"></i>
                <p>
                    <?php echo $_SESSION['user']->nom_utilis . " " . $_SESSION['user']->prenom_utilis; ?>
                </p>
            </div>

            <nav>
                <ul class="sidenav__list">
                    <li class="sidenav__list-item"><a href="./acceuil.php" class="sidebar-link"> Acceuil</a></li>

                    <li class="sidenav__list-item"><a href="./liste-eleves.php" class="sidebar-link"><!--<i class="fas fa-users"></i> --> Liste des élèves</a></li>
                    <li class="sidenav__list-item"><a href="./evaluation.php" class="sidebar-link">Evaluer eleve 15jrs</a></li>
                    <li class="sidenav__list-item"><a href="./devoir.php" class="sidebar-link">Ajouter devoir</a></li>
                    <li class="sidenav__list-item"><a href="./ajouter-note.php" class="sidebar-link">Ajouter note</a></li>
                    <li class="sidenav__list-item"><a href="./remarque.php" class="sidebar-link">Envoyer remarque</a></li>
                    <li class="sidenav__list-item"><a href="./message-urgence.php" class="sidebar-link">Envoyer message
                            urgence</a></li>
                </ul>
            </nav>

            <div class="logout">
                <a href="?logout=true">Déconnexion</a>
            </div>
        </div>
    </aside>

</body>

</html>
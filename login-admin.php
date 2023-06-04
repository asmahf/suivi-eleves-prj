<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>loginpage</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
</head>

<body>
    <section>
        <div class="container">

            <form class="form" method="POST">
                <div id="logo" class="text-center">
                    <img src="./pic/users/admin-settings-male.png">
                </div>
                <h1>Connectez vous</h1>
                <div class="name">
                    <label for="text">Nom d'utilisateur</label>
                    <input id="name" type="text" name="name" placeholder="Nom.prenom" required>
                </div>
                <div class="password">
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <button type="submit" name="login"> Se connecter </button>
                <p> Si vous n'êtes pas administrateur <a href="index.php">Retourner</a></p>
            </form>
            <div id="error"></div>
        </div>
    </section>
    <script>
        function showError(error) {
            let errorElement = document.getElementById("error");
            errorElement.innerHTML = error;
        }
    </script>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['user'])) {
        if ($_SESSION['user']->type_utilis === "admin") {
            header("location:http://localhost/suivi-eleves-prj/admin/index.php", true);
            die("");
        }
    }

    if (isset($_POST['login'])) {
        $username = "Asma";
        $password = "232300";
        $database = new PDO("mysql:host=localhost; dbname=suivieleve;", $username, $password);

        $login = $database->prepare("SELECT * FROM utilisateur WHERE CONCAT(nom_utilis, '.', prenom_utilis) = :name AND mot_de_passe = :password ");
        $login->bindParam("name", $_POST['name']);
        $login->bindParam("password", $_POST['password']);
        $login->execute();

        if ($login->rowCount() === 1) {
            $user = $login->fetchObject();
            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['user'] = $user;

            if ($user->type_utilis === "admin") {
                header("location:./admin/index.php", true);
            } else {
                echo '<script>showError(`<div class="alert alert-danger text-center">vous n\'êtes pas de cette catégorie</div>`);</script>';
                // $_SESSION['user'] = null;
                session_unset();
                // session_destroy();
            }
        } else {
            echo '<script>showError(`<div class="alert alert-danger">nom d\'utilisateur ou mot de passe incorrect</div>`);</script>';
        }
    }

    ?>
</body>

</html>
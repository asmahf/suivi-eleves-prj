<?php
require './config/database.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Enregistrez vous</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
</head>

<body>
    <section>
        <div class="container">

            <form class="form" method="POST">
                <div id="logo"></div>
                <h1>Enregistrez vous</h1>
                <div>
                    <label for="username">Nom*</label>
                    <input id="username" type="text" name="username" required />
                </div>
                <div>
                    <label for="firstname">Prenom*</label>
                    <input id="firstname" type="text" name="firstname" required />
                </div>
                <div>
                    <label for="date_of_birth">Date de naissance*</label>
                    <input id="date_of_birth" type="date" name="date_of_birth" required />
                </div>
                <div>
                    <label for="adresse">Adresse*</label>
                    <input id="adresse" type="text" name="adresse" required />
                </div>
                <div>
                    <label for="num-telephone">Numero telephone*</label>
                    <input id="phone" type="tel" name="num-telephone" required />
                </div>
                <div>
                    <label for="email">Email*</label>
                    <input id="email" type="email" name="email" required />
                </div>
                <div>
                    <label for="password">Mot de passe*</label>
                    <input id="password" type="password" name="password" required />
                </div>
                <div>
                    <label for="profession">Proffesion*</label>
                    <input id="profession" type="text" name="profession" required />
                </div>
                <div id="code-enfant-list">
                    <div>
                        <label for="code-enfant">Code enfant*</label>
                        <input id="code-enfant" type="text" name="codes-enfant[]" required multiple />
                    </div>
                </div>
                <button id="ajouter-code" type="button" class="btn btn-primary btn-sm">Ajouter un autre code</button>
                <button type="submit" name="register">S'inscrire </button>
                <p> Si vous avez un compte <a href="./login-parent.php">Se connecter</a></p>
            </form>
            <div id="alert"></div>
        </div>
    </section>
    <script>
        function showAlert(alert) {
            let alertElement = document.getElementById("alert");
            alertElement.innerHTML = alert;
        }
    </script>
    <?php
    $username = "Asma";
    $password = "232300";
    $database = new PDO("mysql:host=localhost; dbname=suivieleve;", $username, $password);


    if (isset($_POST['register'])) {
        $checkEmail = $database->prepare("SELECT * FROM  utilisateur  WHERE email= :email");
        $email = $_POST['email'];
        $checkEmail->bindParam("email", $email);
        $checkEmail->execute();

        if ($checkEmail->rowCount() > 0) {
            echo '<script>showAlert(`<div class="alert alert-danger" role="alert">
            Ce compte est déjà utilisé</div>`);</script>';
        } else {
            $username = $_POST['username'];
            $firstname = $_POST['firstname'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $date_of_birth = $_POST['date_of_birth'];
            $adress = $_POST['adresse'];
            $phone = $_POST['num-telephone'];
            $profession = $_POST['profession'];
            $codes_enfant = $_POST['codes-enfant'];

            $eleve_array = array();

            foreach ($codes_enfant as $code_enfant) {
                // Vérification du code de l'enfant
                $checkCodeQuery = "SELECT code_eleve ,id_eleve FROM `eleve` WHERE code_eleve = ?";
                $checkCodeStmt = mysqli_prepare($con, $checkCodeQuery);
                mysqli_stmt_bind_param($checkCodeStmt, "s", $code_enfant);
                mysqli_stmt_execute($checkCodeStmt);
                mysqli_stmt_store_result($checkCodeStmt);


                if (mysqli_stmt_num_rows($checkCodeStmt) > 0) {
                    // Récupération de l'ID de l'élève
                    mysqli_stmt_bind_result($checkCodeStmt, $code_eleve, $id_eleve);
                    if (mysqli_stmt_fetch($checkCodeStmt)) {
                        //array 
                        array_push($eleve_array, array("code_eleve" => $code_eleve, "id_eleve" => $id_eleve));
                    }
                } else {
                    echo '<script>showAlert(`<div class="alert alert-danger" role="alert">
                    Veuillez vérifier vos codes enfants et réessayer
                     </div>`);</script>';
                    $eleve_array = array();
                    die;
                    // break;
                }
            }

            //if array empty 
            if ($eleve_array) {
                // Insertion de l'utilisateur parent
                $addUser = "INSERT INTO `utilisateur`( `nom_utilis`, `prenom_utilis`, `date_de_naissance`, `adresse_utilis`, `n°_tlph`, `email`, `mot_de_passe`,`profession`,`type_utilis` )
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, 'parent') ";
                $addUserStmt = mysqli_prepare($con, $addUser);
                mysqli_stmt_bind_param($addUserStmt, "ssssssss", $username, $firstname, $date_of_birth, $adress, $phone, $email, $password, $profession);

                if (mysqli_stmt_execute($addUserStmt)) {


                    $parentId = mysqli_insert_id($con);

                    //foreach array 
                    foreach ($eleve_array as $eleve) {
                        // Modifier l'id_parent dans la table 'eleve' pour l'élève concerné
                        $updateParentIdQuery = "UPDATE `eleve` SET `id_parent` = ? WHERE code_eleve = ?";
                        $updateParentIdStmt = mysqli_prepare($con, $updateParentIdQuery);
                        mysqli_stmt_bind_param($updateParentIdStmt, "is", $parentId, $eleve["code_eleve"]);
                        mysqli_stmt_execute($updateParentIdStmt);

                        // Modifier l'id_parent dans la table 'fiche_eleve' pour l'élève concerné
                        $updateFicheQuery = "UPDATE `fiche_eleve` SET `id_parent` = ? WHERE id_eleve = ?";
                        $updateFicheStmt = mysqli_prepare($con, $updateFicheQuery);
                        mysqli_stmt_bind_param($updateFicheStmt, "ii", $parentId, $eleve["id_eleve"]);


                        if (!mysqli_stmt_execute($updateFicheStmt)) {
                            //delete parent 
                            // row not found, do stuff...
                            echo '<script>showAlert(`<div class="alert alert-danger" role="alert">Une erreur s\'est produite Veuillez  réessayer </div>`);</script>';
                            die;
                        }
                    } // end foreach array

                    echo "<script>showAlert(`<div  class='alert alert-success' role='alert'>Votre compte est crée avec succès.</div>`);</script>";
                } else {

                    // row not found, do stuff...
                    echo '<script>showAlert(`<div class="alert alert-danger" role="alert">
                Veuillez vérifier vos informations et réessayer
        </div>`);</script>';
                }
            }
        }
    }
    ?>
    <script>
        let count = 1;
        let codeEnfantList = document.getElementById('code-enfant-list');
        document.getElementById('ajouter-code').addEventListener('click', function() {
            var div = document.createElement('div');
            var label = document.createElement('label');
            var input = document.createElement('input');

            count++;
            label.textContent = 'Code enfant ' + count;
            input.type = 'text';
            input.name = 'codes-enfant[]';
            input.required = true;

            div.appendChild(label);
            div.appendChild(input);

            codeEnfantList.appendChild(div);
        });
    </script>
</body>

</html>
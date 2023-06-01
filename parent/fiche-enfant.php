<?php
require '../config/database.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche enfant</title>
</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="card-body">
            <div class="mb-3">
                <form method="GET" action="fiche1.php">
                    <label class="h4" for="classe">Choisir enfant :</label>
                    <select class="form-select w-25" name="enfant" id="enfant">
                        <?php

                        $id_parent = $_SESSION['user']->id_utilis;


                        $sql = "SELECT prenom_eleve FROM eleve  WHERE id_parent = ?";
                        $stmt = mysqli_prepare($con, $sql);
                        mysqli_stmt_bind_param($stmt, 'i', $id_parent);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?= $row['prenom_eleve']; ?>"><?= $row['prenom_eleve']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
            </div>
            <div class="mb-3">
                <button type="submit" name="showlist" class="btn btn-primary ">Afficher fiche</button>
            </div>
            </form>
        </div>
    </main>
</body>

</html>
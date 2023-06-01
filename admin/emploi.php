<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../config/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emplois du temps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 4rem 8rem;
            padding: 2rem;
            border: 2px solid;
        }

        [type=submit] {
            /* color: #ececec;
	background-color: #a7a6a2; */
            --primary-500: #3b82f6;
            --white: #fff;
            --borderRadius: .5rem;


            color: var(--white);
            background: var(--primary-500);
            display: inline-block;
            text-decoration: none;
            padding: .8rem 1.2rem;
            border-style: solid;
            border-radius: var(--borderRadius);
            border-color: var(--primary-500);
            margin-top: 1rem;
            font-size: 1.1rem;
            transition: all 0.2s;
        }

        [type=submit]:hover {
            transform: scale(1.05);
        }

        .container .card-body {
            padding-inline: 1.6rem;
        }

        #description {
            padding-left: 0.2rem;
        }
    </style>

</head>

<body>
    <?php include '../header/header.php'; ?>
    <?php include './sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="card-body">
                <form method="GET" action="emploi-temps-download.php">
                    <!-- <label for="id_pub">PDF ID:</label>
                -->
                    <?php  // Check if the description is set in the URL query parameter
                    if (isset($_GET['id_pub'])) {

                        $id_pub = $_GET['id_pub'];
                    } ?>
                    <input type="hidden" name="id_pub" id="id_pub" value="<?php echo $id_pub ?>">

                    <button type="submit">Télécharger le PDF</button>
                    <!-- <button type="submit" name="download">Télécharger le PDF</button> -->
                </form>

                <div id="description">
                    <!-- The description will be displayed here -->
                    <?php  // Check if the description is set in the URL query parameter
                    if (isset($_GET['id_pub'])) {

                        // $id_pub = $_GET['id_pub'];
                        $selectQuery = "SELECT  contenu_pub FROM publication  WHERE id_pub = ? ";
                        $stmt = mysqli_prepare($con, $selectQuery);

                        // Lier le paramètre au contenu du fichier
                        mysqli_stmt_bind_param($stmt, 'i', $id_pub);
                        mysqli_stmt_execute($stmt);

                        // Récupérer le résultat de la requête
                        $result = mysqli_stmt_get_result($stmt);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $contenu_pub = $row['contenu_pub'];

                            // Afficher le contenu (description) de la publication
                            echo "<br/><h3>Contenu: </h3><p> $contenu_pub</p>";
                        } else {
                            echo "Aucune publication n'a été trouvée avec l'ID spécifié.";
                        }
                    } else {
                        echo "Aucun ID de publication n'a été spécifié.";
                    }
                    ?>
                </div>
            </div>
        </div>
        </div>

    </main>

</body>

</html>
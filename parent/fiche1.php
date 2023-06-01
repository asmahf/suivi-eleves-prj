<!DOCTYPE html>
<html>

<head>
    <title>Fiche de suivi d'un enfant</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            background-color: white;
        }

        .container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            gap: 1.2rem;
        }

        .icon-container>a {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            /* margin: 5%; */
            border: 2px solid #f0f0f0;
            border-radius: 10px;
            gap: 0.4rem;
            text-decoration: none;
        }

        .icon-container>a:hover {
            background-color: #f1f1f1;

        }

        .icon-container img {
            display: block;
            width: 100px;
            height: 100px;
            /* border-radius: 50%; */
            object-fit: cover;
            margin-bottom: 10px;
        }

        .icon-container p {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }
    </style>
</head>

<body>

    <?php include '../header/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <?php  // Check if the description is set in the URL query parameter
    if (isset($_GET['enfant'])) {

        $prenom_enfant = $_GET['enfant'];
    } ?>
    <main>
        <div class="container">
            <div class="icon-container">

                <a class="fiche-option" href="devoir.php?enfant=<?php echo $prenom_enfant ?>">
                    <img src="./pic/devoirs.png">
                    <p>Devoirs</p>
                </a>
            </div>

            <div class="icon-container">
                <a class="fiche-option" href="remarque.php?enfant=<?php echo $prenom_enfant ?>">
                    <img src="./pic/remarque.png">
                    <p>Remarques</p>
                </a>

            </div>

            <div class="icon-container">
                <a class="fiche-option" href="note-evaluation.php?enfant=<?php echo $prenom_enfant ?>">
                    <img src="./pic/evaluations.png">
                    <p>Note evaluation</p>
                </a>

            </div>
            <div class="icon-container">
                <a class="fiche-option" href="moyenne.php?enfant=<?php echo $prenom_enfant ?>">
                    <img src="./pic/Graduation-Cap.png">
                    <p>Moyenne </p>
                </a>

            </div>
        </div>
        </div>
    </main>

</body>

</html>
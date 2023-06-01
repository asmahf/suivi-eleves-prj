<!DOCTYPE html>
<html>

<head>
    <title>Acceuil</title>
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
            flex: 1;
            min-width: 200px;
            max-width: 300px;

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
    <?php include '../admin/sidebar.php'; ?>
    <main>

        <div class="container">
            <div class="icon-container">
                <a href="../admin/recupub.php">
                    <img src="publication.png" />
                    <p>Publication</p>
                </a>
            </div>

            <div class="icon-container">
                <a href="../admin/recup-emploi.php">
                    <img src="emplois.png">
                    <p>Emplois de temps</p>
                </a>

            </div>

        </div>
    </main>
</body>

</html>
<?php
require "../connection.php";
session_start();

  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <!-- Icon Font Stylesheet -->
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        /* Custom styles */
    
    </style>
    <title>Le jardinier</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-scroll fixed-top shadow-0">
            <div class="container">
                <a href="index.php" class="navbar-brand"><img class="logo" src="../images/logo.png"
                        alt="Logo" width="70px"></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class='text-decoration-none nav-link link-0' aria-current="page" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class='text-decoration-none nav-link link-0' href="plantes.php">Plantes</a>
                        </li>
                        <?php
                            if (isset($_SESSION['id_client'])) {
                                echo "<li class='nav-item'>
                                            <a class='text-decoration-none nav-link link-0' href='commandes.php'>Mes commandes</a>
                                        </li>
                                        <li class='nav-item'>
                                            <a class='text-decoration-none nav-link link-0' href='profile.php'><img src='../images/user.png' width='42px' /></a>
                                        </li>";
                            } else {
                                echo "<li class='nav-item'>
                                            <button class='btn btn-1'><a class='text-decoration-none nav-link link-0' href='signin.php'>Connexion</a></button>
                                        </li>";
                            }
                        
                        ?>
                        
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Rest of your HTML code -->

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>

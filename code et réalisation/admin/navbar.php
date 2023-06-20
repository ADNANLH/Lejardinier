<?php
session_start();
require "../connection.php";
    $query =  "SELECT * FROM plant";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);    

    // Check if any plant quantity is less than 5
    $lowStockPlants = [];
    foreach ($rows as $row) {
        if ($row['quantite'] < 5) {
            $lowStockPlants[] = $row;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

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
                <a href="plantes.php" class="navbar-brand"><img class="logo" src="../images/logo.png"
                        alt="Logo" width="70px"></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class='text-decoration-none nav-link link' aria-current="page" href="plantes.php">Plantes</a>
                        </li>
                        <li class="nav-item">
                            <a class='text-decoration-none nav-link link' href="commandes.php">Les commandes</a>
                        </li>
                        <!-- Notification icon and dropdown -->
                        <li class="nav-item">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="notification-icon">
                                        <i class="fas fa-bell"></i>
                                    </span>
                                    <?php if (count($lowStockPlants) > 0): ?>
                                    <span class="notification-badge"><?php echo count($lowStockPlants); ?></span>
                                    <?php endif; ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                                    <?php if (count($lowStockPlants) > 0): ?>
                                    <?php foreach ($lowStockPlants as $plant): ?>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <?php echo $plant['nom_plant']; ?> - Stock faible
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            Pas de notifications
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
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
<style>
    /* Custom styles for the notification list */

.dropdown-menu {
  max-height: 250px;
  overflow-y: auto;
}

.dropdown-item {
  display: flex;
  align-items: center;
  white-space: nowrap;
  padding: 0.5rem 1rem;
}

.dropdown-item:hover {
  background-color: #f8f9fa;
}

.notification-badge {
  background-color: #dc3545;
  color: #fff;
  font-size: 12px;
  padding: 2px 6px;
  border-radius: 50%;
}

.notification-icon {
  position: relative;
}

.notification-icon .fas.fa-bell {
  font-size: 1.5rem;
}

.notification-icon .notification-badge {
  position: absolute;
  top: -5px;
  right: -5px;
}

/* Optional: Adjust the position of the dropdown menu */
.dropdown-menu-end {
  right: 0;
  left: auto;
}

</style>
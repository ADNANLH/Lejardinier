<?php
require('navbar.php');
require('../connection.php');
$id_client = isset($_SESSION['id_client']) ? $_SESSION['id_client'] : '';
$stmt = $pdo->prepare('SELECT * FROM `client` WHERE id_client=:id_client');
$stmt->bindParam(':id_client', $id_client);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<body>
    <div class="container">
        <div class="main-body">
            <div class="row justify-content-between">
                <div class="col-md-3">
                    <div class="card-1">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div class="mt-3">
                                    <h4><?php echo $row['nom_client']; ?></h4>
                                    <p class="text mb-1"><?php echo $row['cin']; ?></p>
                                    <p class="text font-size-sm"><?php echo $row['email']; ?></p>
                                    <button type='button' class='btn btn-supp' data-bs-toggle='modal' data-bs-target='#exampleModal-<?php echo $id_client; ?>'>Déconnecter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card-2 mb-3">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nom">Nom</label>
                                            <input type="text" class="form-control custom-input" id="nom" name="nom" value="<?php echo $row['nom_client'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cin">CIN</label>
                                            <input type="text" class="form-control custom-input" id="cin" name="cin" value="<?php echo $row['cin'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" class="form-control custom-input" id="email" name="email" value="<?php echo $row['email'] ?>">
                                </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Mot de passe</label>
                                            <input type="password" class="form-control custom-input" id="password" name="password" placeholder="***********">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirmpass">Confirmer mot de passe</label>
                                            <input type="password" class="form-control custom-input" id="confirmpass" name="confirmpass" placeholder="***********">
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" id="btn" name="modifier" value="Modifier">
                                </div>
                            </form>
                            <?php
                            if (!empty($_SESSION['error'])) {
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            }
                            if (!empty($_SESSION['success'])) {
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            }
                            ?>
                        </div>
                    </div>
                </div>


                    <?php
                    $stmt = $pdo->prepare('SELECT p.* FROM `favorit` f INNER JOIN `plant` p ON f.id_plant = p.id_plant WHERE f.id_client = :id_client');
                    $stmt->bindParam(':id_client', $id_client);
                    $stmt->execute();
                    $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <div class="row row-cols-1">
                        <h2 class="titrei">Mes favorites</h2>
                        <?php
                        foreach ($resultSet as $row) {
                            // Generate the HTML for the plant card
                            $card = '
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <img src="../images/' . $row['image'] . '" class="card-img-top" alt="' . $row['nom_plant'] . '" />
                                    <div class="card-body">
                                        <h5 class="card-title">' . $row['nom_plant'] . '</h5>
                                        <p class="card-text">' . $row['prix'] . ' Dhs</p>
                                        <button class="btn btn-modif">
                                            <a class="text-decoration-none link-1" href="details.php?id_plant=' . $row["id_plant"] . '">Voir plus +</a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            ';

                            echo $card;
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class='modal fade' id='exampleModal-<?php echo $id_client; ?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h1 class='modal-title fs-5' id='exampleModalLabel'>Déconnexion</h1>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Fermer'></button>
            </div>
            <div class='modal-body'>
                Êtes-vous sûr(e) de vouloir vous déconnecter ?
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn' data-bs-dismiss='modal'>Fermer</button>
                <button class="btn btn-4">
                    <a class="text-decoration-none link-1" href="logout.php?id_client=<?php echo $id_client ; ?>">Déconnecter</a>
                </button>
            </div>
        </div>
    </div>
</div>

    <?php
    if (isset($_POST['modifier'])) {
        $nom = $_POST['nom'];
        $cin = $_POST['cin'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmpass = $_POST['confirmpass'];

        // Perform input validation
        if (empty($password) || empty($confirmpass)) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Veuillez remplir tous les champs.</div>";
        } elseif ($password !== $confirmpass) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Les mots de passe ne correspondent pas.</div>";
        } else {
            // Update the client's information in the database
            $stmt = $pdo->prepare('UPDATE `client` SET nom_client=:nom, cin=:cin, email=:email WHERE id_client=:id_client');
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':cin', $cin);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id_client', $id_client);

            if ($stmt->execute()) {
                // Inform the user that the update was successful
                $_SESSION['success'] = "<div class='success alert alert-success' role='alert'>Informations mises à jour avec succès.</div>";
            } else {
                // Inform the user that an error occurred
                $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Erreur lors de la mise à jour des informations.</div>";
            }
        }
    }
    ?>
</body>

<style>
   
    .main-body {
    margin-top: 175px;
    margin-left: 99px;
}
.card-1 {
    width: 270px;
    border: 1px solid #ccc;
    padding: 20px;
    background-color: #39837814;
    border: none;
    box-shadow: 1px 1px 4px #00000040;
}
.alert-danger {
    background-color: #ffe4e7;
    border-color: #f5c6cb;
    color: #721c24;
    padding: 10px;
    margin-top: 8px;
    border-radius: 4px;
    margin-bottom: 10px;
}
.card-2.mb-3 {
    margin-left: 130px;
    width: 610px;
}
.custom-input {
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 4px;
    width: 100%;
}

.custom-input:focus {
    outline: none;
    border-color: #007bff;
}

.custom-input::placeholder {
    color: #999;
}
label {
    display: block;
    font-size: 17px;
    color: #398378;
    margin-bottom: 6px;
}

input[type="text"], input[type="email"], input[type="password"], select.form-control.form-select.border-0.py-3 {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 12px;
    border-radius: 4px;
    font-size: 16px;
    background-color: rgba(57, 131, 120, 0.1);
    color: #398378c9;
}

input[type="submit"] {
    color: #98F9D0;
    background-color: #00695B;
    width: 150px;
    border: none;
    margin-bottom: 14px;
}
h2.titrei {
    color: #016a5c;
    font-size: 23px;
    font-family: initial;
    margin-left: 70px;
}
.h-100 {
    height: 100%!important;
    width: 240px;
    background-color: #f6f4e8;
    border: none;
}
.card-title {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 600;
            font-size: 23px;
            margin-top: 4px;
            color: #224229;
        }

        .card-text {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 600;
            font-size: 14px;
            margin-top: 4px;
            color: #224229;
        }

       
        button.btn.btn-modif {
            background: #00695B;
            width: 100%;
            margin-top: 9px;
            border-radius: 0px;

        }
        button.btn.btn-modif a{
           color: #98F9D0;
        }
        h4 {
            text-transform: capitalize;
            color: #00695b;
        }
        p.text {
            color: #00695b;
        }
        button.btn.btn-supp {
            border: 1px solid #00695b;
            color: #00695b;
            width: 160px;
        }

        a.text-decoration-none.link-1 {
    color: #00695b;

}


    

    .row-cols-1 {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .col {
        flex: 0 0 30%;
        margin: 10px;
    }

    .card-img-top {
        max-height: 200px;
        object-fit: cover;
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card-text {
        color: #555;
    }

    .error {
        color: #dc3545;
        margin-bottom: 10px;
    }

    .success {
        color: #28a745;
        margin-bottom: 10px;
    }
    .col-md-4 {
    margin-bottom: 43px;
}
</style>
<?php
    require "./footer.php";
?>

<?php 
   require('../connection.php');
   require('./navbar.php');
   $id_client = isset($_SESSION['id_client']) ? $_SESSION['id_client'] : '';
   $id_plant = isset($_GET['id_plant']) ? $_GET['id_plant'] : '';

   
   $query = "SELECT * FROM plant WHERE id_plant = :id_plant";
   $stmt = $pdo->prepare($query);
   $stmt->bindParam(':id_plant', $id_plant);
   $stmt->execute();
   
   // Fetch the result set as an associative array
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
   $select = "SELECT COUNT(*) as count FROM favorit WHERE id_client = :id_client AND id_plant = :id_plant";
    $stmt = $pdo->prepare($select);
    $stmt->bindParam(':id_client', $id_client);
    $stmt->bindParam(':id_plant', $id_plant);
    $stmt->execute();

    $favorited = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
   
   
?>
 

<body>
<div class="hero">
        <div class="container ll">
            <div class="row justify-content-between text-center d-flex">
                <div class="col-lg-6">
                    <img src="../images/<?php echo $row['image']; ?>" class="image-1" alt="<?php echo $row['nom_plant']; ?>" />
                </div>
                <div class="col-lg-6 justify-content-start align-items-start">
                    <h2 class="title"><?php echo $row['nom_plant']; ?></h2>
                    <h5 class="title"><?php echo $row['prix']; ?> Dhs</h5>
                    <?php
                        if ($favorited > 0) {
                            echo '<div id="container"><img id="heartIcon" src="../images/heart.png" alt="favorited" /></div>';   
                        } else {
                            echo ' <div id="container"><img id="heartIcon" src="../images/nheart.png" alt="not favorited" /></div>';   
                        }
                    ?>
                    <div class="d-flex">
                        <form method="post" action="" class="input-form">
                            <input type="number" name="qnt" placeholder="0" class="input-qnt" />
                            <input type="submit" name="cmd" value="Demander" class="btn btn-1" />
                        </form>
                    </div>
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
            <div class="row justify-content-center text-center">
                <div class="col-lg-4">
                    <img class="icon" src="../images/sun.png" alt="sun">
                    <span class="lumiere">Lumière</span>
                    <span class="lumiere"><?php echo $row['lumiere']; ?></span>
                </div>
                <div class="col-lg-4">
                    <img class="icon" src="../images/drop.png" alt="arrosage">
                    <span class="lumiere">Arrosage</span>
                    <span class="lumiere"><?php echo $row['arrosage']; ?></span>
                </div>
                <div class="col-lg-4">
                    <img class="icon" src="../images/humidity.png" alt="humide">
                    <span class="lumiere">Humidité</span>
                    <span class="lumiere"><?php echo $row['humidite']; ?></span>
                </div>
            </div>
            <div class="row justify-content-between desc">
                <div class="col-lg-8">
                    <div class="desc">
                        <h2 class="desc">Description</h2>
                        <p class="desc"><?php echo $row['description']; ?></p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="../images/<?php echo $row['image']; ?>" class="image-2" alt="<?php echo $row['nom_plant']; ?>" />
                   
                </div>
            </div>
        </div>
    </div>
   

    
    <?php
    // echo $id_client;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cmd'])) {
        $qnt = isset($_POST['qnt']) ? $_POST['qnt'] : 0;

        if (empty($_SESSION['id_client'])) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Vous devez vous connecter d'abord.</div>";
        } elseif (empty($qnt) || $qnt == 0) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Veuillez choisir une quantité.</div>";
        } elseif ($qnt > $row['quantite']) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>La quantité disponible en stock est de " . $row['quantite'] . ".</div>";
        } else {
            // Insert into Commande table
            $date = date('Y-m-d');
            $etat = "En attente";
            $insertCmdQuery = "INSERT INTO commande (date, id_client, etat) VALUES (:date, :id_client, :etat)";
            $stmtCmd = $pdo->prepare($insertCmdQuery);
            $stmtCmd->bindParam(':date', $date);
            $stmtCmd->bindParam(':id_client', $id_client);
            $stmtCmd->bindParam(':etat', $etat);
            $stmtCmd->execute();

            // Check if the command insertion was successful
            if ($stmtCmd->rowCount() > 0) {
                $id_commande = $pdo->lastInsertId();

                // Insert into Ligne_commande table
                $insertLigneCmdQuery = "INSERT INTO ligne_commande (id_commande, id_plant, qnt_unt) VALUES (:id_commande, :id_plant, :qnt_unt)";
                $stmtLigneCmd = $pdo->prepare($insertLigneCmdQuery);
                $stmtLigneCmd->bindParam(':id_commande', $id_commande);
                $stmtLigneCmd->bindParam(':id_plant', $id_plant);
                $stmtLigneCmd->bindParam(':qnt_unt', $qnt);
                $stmtLigneCmd->execute();

                // Check if the ligne_commande insertion was successful
                if ($stmtLigneCmd->rowCount() > 0) {
                    $_SESSION['error'] ="<div class='alert alert-secondary' id='alert'>Cette commande sera annulée dans 3 jours.</div>";
                } else {
                    $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Erreur lors de l'insertion de la ligne de commande.</div>";
                }
            } else {
                $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Erreur lors de l'insertion de la commande.</div>";
            }
        }
    }

    ?>
    
</body>
<script type="text/javascript">
        setTimeout(function () {

            // Closing the alert
            $('#alert').alert('close');
        }, 5000);
    </script>
<?php
        require('./scriptfav.php');
    ?>
<style>
   
   .container.ll {
    margin-top: 160px;
}
img.image-1 {
    width: 400px;
    transition: transform 0.3s ease-in-out;
    border-radius: 8px;
    box-shadow: 0px 0px 8px #00000045;
}

    img.image-1:hover {
        transform: scale(1.05);
    }

h2.title {
    font-size: 36px;
    font-weight: 700;
    color: #224229;
    margin-bottom: 23px;
}
h5.title {
    font-size: 19px;
    font-weight: 700;
    color: #224229;
    margin-bottom: 23px;
}
.row.justify-content-center.text-center.d-flex > div {
    margin: 20px 0px;
}
.col-lg-4 {
    margin: 101px 0px;
    display: flex;
    flex-direction: column;
}
img.icon {
    width: 79px;
    align-self: center;
    margin-bottom: 16px;
    transition: transform 0.3s ease-in-out;

}
img.icon:hover{
    transform: scale(1.10);
}
span.lumiere {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 9px;
    line-height: 15px;
    text-align: center;
    color: #00695B;
}
.row.justify-content-between.desc {
    background: #fdf6e9;
    box-shadow: 0px 0px 17px #48474738;
    border-radius: 12px;
    margin-bottom: 118px;
    height: 680px;
}
.alert-danger {
    width: 440px;
    margin-top: 70px;
}
.alert-secondary {
    width: 440px;
    margin-top: 70px;
}
.col-lg-8 {
    margin: 114px 0px;
    padding: 41px;
}
img.image-2 {
    width: 320px;
    border-radius: 6px;
    box-shadow: 0px 0px 17px #00000073;

}
div.desc {
    margin-left: 25px;
}
h2.desc{

    font-size: 36px;
    font-weight: 700;
    color: #224229;
    margin-bottom: 23px;
}
p.desc {
    font-size: 16px;
    font-weight: 400;
    color: #224229;
}
   
    .input-form {
        display: flex;
        align-items: center;
        justify-content: center;
    }

   
    input.input-qnt {
        width: 54px;
        border: 1px solid #398378;
        border-radius: 4px;
        background-color: #f3f0e9;
        margin-right: 10px;
    
    }
    input.btn.btn-1 {
    color: #98F9D0;
    background-color: #00695B;
    width: 170px;
    height: 46px;
    font-size: 16px;
    margin-left: 12px;
    border-radius: 5px;
}

    .row.justify-content-between.text-center.d-flex > .col-lg-6 {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .row.justify-content-center.text-center.d-flex > div {
        margin: 20px 10px;
    }

    #heartIcon {
        cursor: pointer;
        transition: transform 0.3s ease-in-out;
        margin-bottom: 60px;
    }

    #heartIcon:hover {
        transform: scale(1.2);
    }

    #container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }




    


</style>
<?php
    require "./footer.php";
?>
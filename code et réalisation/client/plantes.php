<?php

require "../connection.php";
require "./navbar.php";
$id_client = isset($_SESSION['id_client']) ? $_SESSION['id_client'] : '';
?>

<body>
    <div class="container ll">
    <div class="row">
        <h2 class="titri">Le jardinier</h2>
            
            <div class="col-lg-12 text-center justify-content-center">
                <form action="" method="post" class="d-flex align-items-center">
                    <input type="text" name="nom" placeholder="Nom de plante" class="input-nom" />
                    <input type="number" name="prix" placeholder="Max prix" class="input-prix" />
                    <input type="submit" name="btn" value="Rechercher" class="btn btn-1" />
                </form>
            </div>
            <div class="col-lg-12 justify-content-start">
            <?php
                if(!empty($_POST['nom'])){
                    echo "<span class='filter'> Nom de plante : ". $_POST['nom'] ."</span>";
                } 
                if(!empty($_POST['prix'])){
                    echo "<span class='filter'>Max prix : ". $_POST['prix'] ." Dhs</span>";
                } 
            ?>
        </div>
        </div>
        <?php
        if (empty($_POST['nom']) && empty($_POST['prix'])) {
            $query = "SELECT * FROM plant";
            $stmt = $pdo->query($query);
            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
            foreach ($resultSet as $row) {

                // Generate the HTML for the plant card
                $card = '
                <div class="col">
                        <div class="card h-100">
                            <img src="../images/' . $row['image'] . '" class="card-img-top" alt="' . $row['nom_plant'] . '" />
                            <div class="card-body">
                                <h5 class="card-title">' . $row['nom_plant'] . '</h5>
                                <p class="card-text">' . $row['prix'] . ' Dhs</p>
                                <button class="btn btn-4">
                                    <a class="text-decoration-none link-1" href="details.php?id_plant=' . $row["id_plant"] . '">Voir plus +</a>
                                </button>
                            </div>
                        </div>
                </div>
                ';

                echo $card;
            }
            echo '</div>';
        } elseif (isset($_POST['nom']) || isset($_POST['prix'])) {
            if (isset($_POST['btn'])) {
                $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
                $prix = isset($_POST['prix']) ? $_POST['prix'] : '';

                $query = "SELECT * FROM plant WHERE ";
                $params = array();

                if (!empty($nom)) {
                    $query .= "nom_plant LIKE :nom";
                    $params[':nom'] = '%' . $nom . '%';
                }

                if (!empty($prix)) {
                    if (!empty($nom)) {
                        $query .= " AND ";
                    }
                    $query .= "prix <= :prix";
                    $params[':prix'] = $prix;
                }

                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($resultSet) > 0) {
                    echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
                    foreach ($resultSet as $row) {
                        // Generate the HTML for the plant card
                        $card = '
                            <div class="col">
                                <div class="card h-100">
                                    <img src="../images/' . $row['image'] . '" class="card-img-top" alt="' . $row['nom_plant'] . '" />
                                    <div class="card-body">
                                        <h5 class="card-title">' . $row['nom_plant'] . '</h5>
                                        <p class="card-text">' . $row['prix'] . ' Dhs</p>
                                        <button class="btn btn-4">
                                            <a class="text-decoration-none link-1" href="details.php?id_plant=' . $row["id_plant"] . '">Voir plus +</a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        ';

                        echo $card;
                    }
                    echo '</div>';
                } else {
                    echo '<div class="row">';
                    echo '<div class="col-lg-12 text-center">';
                    echo '<div class="alert alert-info" id="alert">Aucun produit correspondant à votre recherche n\'a été trouvé.</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }
        ?>
    </div>

</body>

</html>

<style>
  body {
            
            background-color: #F6F4E8;

            margin-top: 152px;
}


       

        .container.ll {
            max-width: 1140px;
            margin: 0 auto;
        }
        h2.titri {
            /* color: yellow; */
            font-family: 'Inria Serif';
            font-style: normal;
            font-weight: 700;
            font-size: 39px;
            margin-left: 0px;
            margin-top: 9px;
            /* line-height: 20px; */
            color: #00695B;
        }
        .col-lg-12.text-center.justify-content-center {
            margin-bottom: 63px;
        }

        form.d-flex.align-items-center {
            margin-top: 20px;
        }

        input[type="text"], input[type="number"] {
            padding: 10px;
            background-color: #edeada;
            border-radius: 6px;
            /* border: 1px solid #224229; */
            margin-right: 10px;
            font-size: 16px;
            padding: 13px 0px 13px 20px;
            border: none;
        }

        input[type="submit"] {
            background: #00695B;
            border-radius: 6px;
            width: 330px;
            color: #98F9D0;
            font-size: 19px;
        }
        .col-lg-12.justify-content-start {
            margin-bottom: 20px;
        }
               

        span.filter {
            background: none;
            color: #00695b;
            font-size: 16px;
            font-family: initial;
            font-weight: bold;
            margin-right: 30px;
        }

        .col {
            height: 430px;
            margin-top: 68px;
        }
        .card-body {
            padding: 19Px 0px 7px 0px;
        }

        .card.h-100 {
            border: none;
            width: 270px;
            background-color: #f6f4e8;
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

        button.btn.btn-4 {
            background: #00695B;
            width: 100%;
            margin-top: 9px;
            border-radius: 0px;
        }

        img.card-img-top {
            height: 300px;
            width: auto;
        }

        a.text-decoration-none.link-1 {
            color: #98F9D0;
            font-weight: bold;
            font-size: 17px;
        }
        div#alert {
            margin-top: 64px;
        }
</style>


</html>
<?php
    require "./footer.php";
?>
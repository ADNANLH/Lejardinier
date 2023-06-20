<?php

    
    require "../connection.php";
    require "./navbar.php";
    $id_client = isset($_SESSION['id_client']) ? $_SESSION['id_client'] : '';
    

?>

<body>

    <div class="hero">
        <div class="container ll">
            <div class="row justify-content-center "> 
                <div class="col-lg-12 text-center searching">
                    <h1 class="grtitre">Bloom avec notre nouvelle collection pour l'été</h1>
     
                        <div class="col-md-12">
                            <button class="btn btn--radius " type="submit"><a href="plantes.php" class="text-decoration-none link-3">Voir plus +</a></button>
                        </div>

                 
                </div>
            </div>

        </div>
       
    </div>
    <h2 class="titri">Collections en vedette</h2>



  

    <?php
// Assuming you have a PDO database connection already established

// Query to fetch 6 random plant records from the database
$query = "SELECT * FROM plant ORDER BY RAND() LIMIT 6";
$stmt = $pdo->query($query);

// Fetch the result set as an associative array
$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Iterate through the result set and display the plant cards
echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
foreach ($resultSet as $row) {
   

    // Generate the HTML for the plant card
    $card = '
        <div class="col">
            <div class="card h-100">
                <img src="../images/' .  $row['image'] . '" class="card-img-top" alt="' . $row['nom_plant'] . '" />
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

    // Output the plant card
    echo $card;
}
echo '</div>';


?>
<button class="btn btn-modif">
<a class="text-decoration-none link-6" href="plantes.php">Afficher tout</a></button>

</body>
<style>
  
  body {
            background-color: #F6F4E8;
        }

        /* Styles for large screens */

        .container.ll {
            max-width: 1519px;
        }

        .col-lg-12.text-center.searching {
            margin-top: 107px;
            height: 421px;
            background-image: url('https://bloomscape.com/cdn-cgi/image/quality=75,fit=scale-down,height=1000,width=2000,metadata=copyright,format=webp/wp-content/uploads/2022/04/BloomscapeLocation5300-hph.jpg');
            background-size: 100%;
            background-position-y: -71px;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        h1.grtitre {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 700;
            margin-top: 100px;
            font-size: 59px;
            text-align: center;
            color: #FCDCC3;
        }
        h2.titri {
            /* color: yellow; */
            font-family: 'Inria Serif';
            font-style: normal;
            font-weight: 700;
            font-size: 41px;
            margin-left: 160px;
            margin-top: 45px;
            /* line-height: 20px; */
            color: #00695B;
        }

        .col-md-12 {
            margin: 90px 4px 4px 4px;
        }

        button.btn.btn--radius {
            width: 230px;
            background-color: #FCDCC3;
            border-radius: 16px;
        }

        .text-decoration-none.link-3 {
            text-decoration: none !important;
            color: #224229;
            font-size: 18px;
        }

        .row.row-cols-1.row-cols-md-3.g-4 {
            width: 1090px;
            margin-left: 230px;
            margin-top: 22px;
        }

        .col {
            height: 430px;
            margin-top: 68px;
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
        .card-body {
            padding: 19Px 0px 7px 0px;
        }

        button.btn.btn-modif {
            width: 416px;
            /* border: solid 1px #00695b; */
            /* position: absolute; */
            margin-left: 40%;
            border: 2px solid #00695B;
            border-radius: 0px;
            margin: 137px 9px 29px 525px;
        }

        .link-6 {
            text-decoration: none !important;
            color: #00695B;
            font-weight: bold;
            font-size: 16px;
        }

        /* Media queries for responsiveness */

        @media (max-width: 1200px) {
            .container.ll {
                max-width: 100%;
            }

            .row.row-cols-1.row-cols-md-3.g-4 {
                width: 100%;
                margin-left: 0;
                margin-top: 22px;
            }

            .col {
                height: auto;
                margin-top: 20px;
            }

            .card.h-100 {
                width: 100%;
            }

            button.btn.btn-modif {
                margin-left: auto;
                margin-right: auto;
            }
        }

        @media (max-width: 768px) {
            .col-md-12 {
                margin: 30px 4px 4px 4px;
            }
        }

</style>


</html>
<?php
    require "./footer.php";
?>


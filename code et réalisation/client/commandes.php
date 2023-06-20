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
                    <h1 class="grtitre">Consulter et Gérer Mes Commandes</h1>
                    
                </div>
            </div>
        </div>
    </div>
            
            <?php
                $query =  "SELECT c.*, p.*, cl.*, lc.*
                    FROM 
                    Commande c
                    JOIN Ligne_commande lc ON c.id_commande = lc.id_commande
                    JOIN Plant p ON lc.id_plant = p.id_plant 
                    JOIN Client cl ON c.id_client = cl.id_client WHERE cl.id_client = :id_client
                ";

                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':id_client', $id_client);

                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);    
                $table = "<table class='table'>
            
                <thead>
                  <tr>
                    <th scope='col'>N°</th>
                    <th scope='col'>Date</th>
                    <th scope='col'>Date fin</th>
                    <th scope='col'>Nom de plante</th>
                    <th scope='col'>Etat</th>
                    <th scope='col'>Prix</th>
                    <th scope='col'>Quantité</th>
                    <th scope='col'>Prix total</th>
                    <th scope='col'>Actions</th>
                  </tr>
                </thead>
                <tbody>";
                foreach ($rows as $row) {
                    $prixUnt = $row['prix'] * $row['qnt_unt'];
                    $suppButton = '';
                    if ($row['etat'] == 'En attente' || $row['etat'] == 'en attente' ) {
                        $suppButton = "<button type='button' class='btn btn-modif' data-bs-toggle='modal' data-bs-target='#valideModal-" . $row['id_ligne_cmd'] . "'>Supprimer</button>";
                    }
                
                    $dateFin = date('Y-m-d', strtotime($row['date'] . ' + 3 days'));
                
                    $table .= "<tr>
                        <td>" . $row['id_ligne_cmd'] . "</td>
                        <td>" . $row['date'] . "</td>
                        <td>" . $dateFin . "</td>
                        <td>" . $row['nom_plant'] . "</td>
                        <td>" . $row['etat'] . "</td>
                        <td>" . $row['prix'] . " Dhs</td>
                        <td>" . $row['qnt_unt'] . "</td>
                        <td class='font-weight-bold'>" . $prixUnt . " Dhs</td>
                        <td>$suppButton</td>
                    </tr>";
                    $table .= "<div class='modal fade' id='valideModal-" . $row['id_ligne_cmd'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Supprimer la commande</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                Voulez-vous vraiment supprimer cette commande?                            
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn' data-bs-dismiss='modal'>Annuler</button>
                                <button type='button' class='btn btn-modif'>
                                    <a class='text-decoration-none link-1' href='suppCmd.php?id_ligne_cmd=" . $row['id_ligne_cmd'] . "'>Supprimer</a>
                                </button>
                            </div>
                    </div>
                </div>";
                }
                $table .= "</tbody></table>";
                echo $table;
            ?>
 
       
        
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
            height: 435px;
            background-image: url('https://bloomscape.com/cdn-cgi/image/quality=75,fit=scale-down,height=1000,width=2000,metadata=copyright,format=webp/wp-content/uploads/2023/03/2023_03_07_Spring-Assortment_SiteHero_1-scaled-e1678289576164.jpg');
            background-size: 100%;
            background-position-y: -193px;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin-bottom: 80px;
        }

        h1.grtitre {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 700;
            margin-top: 237px;
            font-size: 59px;
            text-align: center;
            color: #FCDCC3;
        }
        .table {
            width: 80%;
            background-color: #F3F0E9;
            width: 86%;
            border-collapse: collapse;
            position: relative;
            left: 8%;
            border-radius: 6px;
        }




button.btn.btn-1 {
    background-color: #00695B;
    height: 40px;
    border-radius: 2px 2px 2px 2px;
    width: 116px;
}

button.btn.btn-modif {
    background-color: #398378;
    height: 36px;
    border-radius: 9px;
    width: 100px;
    color: white;
}

button.btn.btn-supp {
    color: #00695b;
    border-radius: 9px;
    border: 0.8px solid #398378;
    width: 100px;
    height: 36px;
}

::placeholder {
    color: rgba(57, 131, 120, 0.74);
}

a.link-1 {
    color: #ffffff;
    font-weight: 400;
    font-size: 14px;
}

form.d-flex {
    margin-bottom: 20px;
}


.table th {
    padding: 17px 7px;
    text-align: left;
    font-weight: 700;
    background: rgb(225 223 218);
    font-size: 18px;
    color: #398378;
}

.table td {
    padding: 19px 13px;
    font-size: 14px;
    color: #398378;
    border-block-width: 3px;
}
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    max-width: 600px;
    border-radius: 6px;
}

.modal-header {
    padding-bottom: 10px;
    border-bottom: 1px solid #ddd;
}

.modal-title {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #398378;
}
.modal-body {
    margin-top: 20px;
    margin-left: 0px;
    width: 533px;
    margin-bottom: 20px;
}

.modal-footer {
    padding-top: 10px;
    border-top: 1px solid #ddd;
    text-align: right;
}

.modal-footer .btn {
    color: #00695b;
    border-radius: 9px;
    border: 0.8px solid #398378;
    width: 100px;
    height: 36px;
}


</style>
<?php
    require "./footer.php";
?>
<html lang="en">
<?php

require "../connection.php";
require "./navbar.php";
?>

<body>
    <div class="container ll">
        <div class="filter">
            <div class="row">
                <div class="col-lg-4 text-center justify-content-center">
                    <h1 class="grtitre">Les plantes</h1>
                </div>
                <div class="col-lg-4 text-center justify-content-center">
                    <form action="" method="post" class="d-flex align-items-center justify-content-center mb-3">
                        <input type="text" name="search" placeholder="Le nom de plante" class="input-search" />
                        <input type="submit" name="btn" value="Recherche" class="btn btn-1" />
                    </form>
                </div>
                <div class="col-lg-4 text-center justify-content-center">
                    <button class="btn btn-1">
                        <a href="ajoute.php" class="link-1 text-decoration-none">Ajouter</a>
                    </button>
                </div>
            </div>
        </div>

        <?php
        if (empty($_POST['search'])) {
            $query =  "SELECT * FROM plant";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $table = "<table class='table'>
                <thead>
                    <tr>
                        <th scope='col'>N°</th>
                        <th scope='col'>Image</th>
                        <th scope='col'>Nom</th>
                        <th scope='col'>Prix</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Lumière</th>
                        <th scope='col'>Arrosage</th>
                        <th scope='col'>Humidité</th>
                        <th scope='col'>Quantité</th>
                        <th scope='col'>Actions</th>
                    </tr>
                </thead>
                <tbody>";
            foreach ($rows as $row) {
                $table .= "<tr>
                    <td>" . $row['id_plant'] . "</td>
                    <td><img src='../images/" . $row['image'] . "' width='90px'/></td>
                    <td>" . $row['nom_plant'] . "</td>
                    <td>" . $row['prix'] . " dhs</td>
                    <td class='description-truncate'>". $row['description']." ></td>
                    <td>" . $row['lumiere'] . "</td>
                    <td>" . $row['arrosage'] . "</td>
                    <td>" . $row['humidite'] . "</td>
                    <td>" . $row['quantite'] . "</td>
                    <td>
                    
                        <button class='btn btn-modif'>
                        <a class='text-decoration-none link-1' href='modifier.php?id_plant=" . $row['id_plant'] . "'>Modifier</a>
                        </button>
                        <button type='button' class='btn btn-supp' data-bs-toggle='modal' data-bs-target='#exampleModal-" . $row['id_plant'] . "'>Supprimer</button>
                  
                    </td>
                </tr>";
                echo "<div class='modal fade' id='exampleModal-" . $row['id_plant'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Suppression d'un plante</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                Etes-vous sûr que vous voulez supprimer la Plante " . $row['nom_plant'] . " ?       
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn' data-bs-dismiss='modal'>Close</button>
                                <button type='button' class='btn btn-modif'>
                                    <a class='text-decoration-none link-1' href='supprimer.php?id_plant=" . $row['id_plant'] . "'>Supprimer</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>";
            }
            echo $table;
            echo "</tbody></table>";
        } elseif (isset($_POST['search'])) {
            if (isset($_POST['btn'])) {
                $search = $_POST['search'];
                $query = "SELECT * FROM plant WHERE nom_plant LIKE '%$search%'";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $table = "<table class='table'>
                <thead>
                    <tr>
                        <th scope='col'>N°</th>
                        <th scope='col'>Image</th>
                        <th scope='col'>Nom</th>
                        <th scope='col'>Prix</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Lumière</th>
                        <th scope='col'>Arrosage</th>
                        <th scope='col'>Humidité</th>
                        <th scope='col'>Quantité</th>
                        <th scope='col'>Actions</th>
                    </tr>
                </thead>
                <tbody>";
                foreach ($rows as $row) {
                    $table .= "<tr>
                    <td>" . $row['id_plant'] . "</td>
                    <td><img src='../images/" . $row['image'] . "' width='90px'/></td>
                    <td>" . $row['nom_plant'] . "</td>
                    <td>" . $row['prix'] . " dhs</td>
                    <td class='description-truncate'>". $row['description']." ></td>
                    <td>" . $row['lumiere'] . "</td>
                    <td>" . $row['arrosage'] . "</td>
                    <td>" . $row['humidite'] . "</td>
                    <td>" . $row['quantite'] . "</td>
                    <td>
                        <button class='btn btn-modif'>
                        <a class='text-decoration-none link-1' href='modifier.php?id_plant=" . $row['id_plant'] . "'>Modifier</a>
                        </button>
                        <button type='button' class='btn btn-supp' data-bs-toggle='modal' data-bs-target='#exampleModal-" . $row['id_plant'] . "'>Supprimer</button>           
                    </td>
                </tr>";
                echo "<div class='modal fade' id='exampleModal-" . $row['id_plant'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Suppression d'un plante</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            Etes-vous sûr que vous voulez supprimer la Plante " . $row['nom_plant'] . " ?       
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn' data-bs-dismiss='modal'>Close</button>
                            <button type='button' class='btn btn-modif'>
                                <a class='text-decoration-none link-1' href='supprimer.php?id_plant=" . $row['id_plant'] . "'>Supprimer</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>";
                }
                echo $table;
                echo "</tbody></table>";
            }
        }
        ?>
    </div>
</body>

<script>
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const quantityCell = row.querySelector('td:nth-child(9)');
        const quantity = parseInt(quantityCell.textContent);
        if (quantity < 5) {
            row.classList.add('low-stock');
        }
    });
</script>

</html>
<style>
.container.ll {
    margin-top: 135px;
}

.filter {
    padding: 40px;
}

h1.grtitre {
    font-size: 34px;
    font-weight: 700;
    color: #398378;
}

input.input-search {
    width: 249px;
    border: none;
    padding: 6px 9px 6px 10px;
    height: 40px;
    background: #e1dfda!important;
    border-radius: 2px 0px 0px 2px;
}
input.btn.btn-1 {
    color: #98F9D0;
    background-color: #00695B;
    font-weight: 700;
    font-size: 15px;
    border-radius: 0px 2px 2px 0px;
    width: 110px;
    height: 40px;
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
    margin-bottom: 9px;
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

.table {
    width: 100%;
    background-color: #F3F0E9;
    width: 100%;
    border-collapse: collapse;
    border-radius: 6px;
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
  
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
}

.modal-title {
    margin: 0;
    font-size: 18px;
}

.modal-body {
    margin-top: 20px;
    margin-bottom: 20px;
}

.modal-footer {
    margin-top: 20px;
    text-align: right;
}

.modal-footer .btn {
    margin-left: 10px;
}

.btn-group {
    display: inline-block;
}

.btn-group .btn {
    margin-right: 10px;
}
tr.low-stock {
    background-color: #f7e1e1;
}
.description-truncate {
    max-height: 4em;
    overflow: hidden;
    /* text-overflow: ellipsis; */
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}


</style>

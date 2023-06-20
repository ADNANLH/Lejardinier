<html lang="en">
<?php

require "../connection.php";
require "./navbar.php";

?>

<body>

    <div class="hero">
    <div class="container ll">
        <div class="row">
            <div class="col-lg-4 text-center justify-content-center">
                <h1 class="title">Les commandes</h1>
            </div>
            <div class="col-lg-8 text-center justify-content-center">
                <form action="" method="post" class="d-flex align-items-center">
                    <input type="text" name="cin" placeholder="CIN" class="input-cin" />
                    <input type="date" name="date" placeholder="date de commande" class="input-date" />
                    <input type="submit" name="btn" value="Recherche" class="btn btn-1" />
                </form>
            </div>

        </div>
    </div>



        <?php
         if(empty($_POST['cin']) && empty($_POST['date']) ){
            $query =  "SELECT c.*, p.*, cl.*, lc.*
                FROM 
                commande c
                JOIN ligne_commande lc ON c.id_commande = lc.id_commande
                JOIN plant p ON lc.id_plant = p.id_plant 
                JOIN client cl ON c.id_client = cl.id_client 
            ";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);    
            $table = "<table class='table '>
            
            <thead>
              <tr>
                <th scope='col'>N°</th>
                <th scope='col'>Date</th>
                <th scope='col'>Nom de client</th>
                <th scope='col'>CIN</th>
                <th scope='col'>Etat</th>
                <th scope='col'>N° plantes</th>
                <th scope='col'>Prix total</th>
                <th scope='col'>Actions</th>
              </tr>
            </thead>
            <tbody>";
            foreach ($rows as $row) {
                $prixUnt = $row['prix'] * $row['qnt_unt'];
                $validerButton = '';
                if ($row['etat'] != 'Terminée') {
                    $validerButton = "<button type='button' class='btn btn-modif' data-bs-toggle='modal' data-bs-target='#valideModal-" . $row['id_ligne_cmd'] . "'>Valider</button>";
                }
            
                $table .= "<tr>
                    <td>" . $row['id_ligne_cmd'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['nom_client'] . "</td>
                    <td>" . $row['cin'] . "</td>
                    <td>" . $row['etat'] . "</td>
                    <td>" . $row['qnt_unt'] . "</td>
                    <td class='font-weight-bold'>" . $prixUnt . " Dhs</td>
                    <td>
                    $validerButton
                    <button type='button' class='btn btn-supp' data-bs-toggle='modal' data-bs-target='#exempleModal-" . $row['id_ligne_cmd'] . "'>Détails</button>
                    </td>
                </tr>";
            }
            
            $table .= "</tbody></table>";
            
            foreach ($rows as $row) {
                $validerButton = '';
                if ($row['etat'] != 'Terminée') {
                    $validerButton = "<button type='button' class='btn btn-modif' data-bs-toggle='modal' data-bs-target='#valideModal-" . $row['id_ligne_cmd'] . "'>Valider</button>";
                }
                $prixUnt = $row['prix'] * $row['qnt_unt'];
            
                $table .= "<div class='modal fade' id='valideModal-" . $row['id_ligne_cmd'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Valider la commande</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                voulez-vous valider cette commande ?   
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-supp' data-bs-dismiss='modal'>Close</button>
                                <button type='button' class='btn btn-modif'><a class =' text-decoration-none link-1' href='validate.php?id_ligne_cmd=" . $row['id_ligne_cmd'] . "'>Valider</a></button>
                            </div>
                        </div>
                    </div>
                </div>";
            
                $table .= "<div class='modal fade' id='exempleModal-" . $row['id_ligne_cmd'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Détails de commande</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <table class='table 2'>
                                    <thead>
                                        <tr>
                                            <th scope='col'>Nom</th>
                                            <th scope='col'>Prix</th>
                                            <th scope='col'>Quantité</th>
                                            <th scope='col'>Prix total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>" . $row['nom_plant'] . "</td>
                                            <td>" . $row['prix'] . " dhs</td>
                                            <td>" . $row['qnt_unt'] . "</td>
                                            <td>" . $prixUnt . " dhs</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-supp' data-bs-dismiss='modal'>Close</button>
                                $validerButton 
                            </div>
                        </div>
                    </div>
                </div>";
            }
            
            echo $table;
            
            




        }elseif(isset($_POST['cin']) || isset($_POST['date'])){
            if(isset($_POST['btn'])){
                $date = isset($_POST['date']) ? $_POST['date'] : '';
                $cin = isset($_POST['cin']) ? $_POST['cin'] : '';
            

                $query =  "SELECT c.*, p.*, cl.*, lc.*
                FROM 
                commande c
                JOIN ligne_commande lc ON c.id_commande = lc.id_commande
                JOIN plant p ON lc.id_plant = p.id_plant 
                JOIN client cl ON c.id_client = cl.id_client WHERE
            ";
            $params = array();
            
            
                if (!empty($date)) {
                    
                    $query .= " c.date = :date";
                    $params[':date'] =  $date ;
                }
        
                if (!empty($cin)) {
                    if (!empty($date)) {
                        $query .= " AND";
                    }
                    $query .= " cl.cin = :cin";
                    $params[':cin'] = $cin;
                }
                
      
                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); 

                $table = "<table class='table '>
            
            <thead>
              <tr>
                <th scope='col'>N°</th>
                <th scope='col'>Date</th>
                <th scope='col'>Nom de client</th>
                <th scope='col'>CIN</th>
                <th scope='col'>Etat</th>
                <th scope='col'>N° plantes</th>
                <th scope='col'>Prix total</th>
                <th scope='col'>Actions</th>
              </tr>
            </thead>
            <tbody>";
            foreach ($rows as $row) {
                $prixUnt = $row['prix'] * $row['qnt_unt'];
                $validerButton = '';
                if ($row['etat'] != 'Terminée') {
                    $validerButton = "<button type='button' class='btn btn-modif' data-bs-toggle='modal' data-bs-target='#valideModal-" . $row['id_ligne_cmd'] . "'>Valider</button>";
                }
            
                $table .= "<tr>
                    <td>" . $row['id_ligne_cmd'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['nom_client'] . "</td>
                    <td>" . $row['cin'] . "</td>
                    <td>" . $row['etat'] . "</td>
                    <td >" . $row['qnt_unt'] . "</td>
                    <td class='font-weight-bolder'>" . $prixUnt . " Dhs</td>
                    <td>
                    $validerButton
                    <button type='button' class='btn btn-supp' data-bs-toggle='modal' data-bs-target='#exempleModal-" . $row['id_ligne_cmd'] . "'>Détails</button>
                    </td>
                </tr>";
            }
            
            $table .= "</tbody></table>";
            
            foreach ($rows as $row) {
                $prixUnt = $row['prix'] * $row['qnt_unt'];


            
                $table .= "<div class='modal fade' id='valideModal-" . $row['id_ligne_cmd'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Valider la commande</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                            voulez-vous valider cette commande ?   
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-supp' data-bs-dismiss='modal'>Close</button>
                                <button type='button' class='btn btn-modif'><a class='text-decoration-none link-1' href='validate.php?id_ligne_cmd=" . $row['id_ligne_cmd'] . "'>Valider</a></button>
                            </div>
                        </div>
                    </div>
                </div>";
            
                $table .= "<div class='modal fade' id='exempleModal-" . $row['id_ligne_cmd'] . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Détails de commande</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <table class='table 2'>
                                    <thead>
                                        <tr>
                                            <th scope='col'>Nom</th>
                                            <th scope='col'>Prix</th>
                                            <th scope='col'>Quantité</th>
                                            <th scope='col'>Prix total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>" . $row['nom_plant'] . "</td>
                                            <td>" . $row['prix'] . " Dhs</td>
                                            <td>" . $row['qnt_unt'] . "</td>
                                            <td>" . $prixUnt . " Dhs</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-supp' data-bs-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </div>
                </div>";
            }
            
            echo $table;
            
              
            


            }



        }

        
        ?>

    </div>


   

</body>

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

input.input-cin {
    width: 249px;
    border: none;
    padding: 6px 9px 6px 10px;
    height: 40px;
    background: #e1dfda!important;
    border-radius: 2px 0px 0px 2px;
}
input.input-date {
    width: 249px;
    margin: 2px 11px;
    border: none;
    padding: 6px 9px 6px 10px;
    height: 40px;
    background: #e1dfda!important;
    border-radius: 2px;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    color: #398378;
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

.table {
  
    width: 80%;

    background-color: #F3F0E9;
    width: 81%;
    border-collapse: collapse;
    position: relative;
    left: 10%;
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
table.table.\32 {
    left: 0%;
}


</style>
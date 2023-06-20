<?php
    require('../connection.php');
    $id_ligne_cmd = $_GET['id_ligne_cmd'];

    // Update the etat and quantite values in the commande table
    $query = "UPDATE commande c
    INNER JOIN ligne_commande lc ON c.id_commande = lc.id_commande
    INNER JOIN plant p ON p.id_plant = lc.id_plant
    SET c.etat = 'Terminée', p.quantite = p.quantite - lc.qnt_unt
    WHERE lc.id_ligne_cmd = :id_ligne_cmd";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_ligne_cmd', $id_ligne_cmd);
    $stmt->execute();

    header("location: commandes.php");

?>
<?php
    require('../connection.php');
    $id_ligne_cmd = $_GET['id_ligne_cmd'];
    echo $id_plant;
    // require('./navbar.php');
    if(isset($id_ligne_cmd)){
         // Delete ligne_commande
        $sql1 = "DELETE FROM ligne_commande WHERE id_ligne_cmd = :id_ligne_cmd";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindParam(':id_ligne_cmd', $id_ligne_cmd);
        $stmt1->execute();

        // Delete commande if no associated ligne_commande exists
        $sql2 = "DELETE FROM commande WHERE id_commande NOT IN (SELECT id_commande FROM ligne_commande)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute();

        header("Location: commandes.php");
        exit();
    }


?>

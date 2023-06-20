<?php
require('../connection.php');

$id_plant = $_GET['id_plant'];

if (isset($id_plant)) {
    // Delete the plant from the favorit table
    $deleteFavoritSql = "DELETE FROM favorit WHERE id_plant = :id_plant";
    $deleteFavoritStmt = $pdo->prepare($deleteFavoritSql);
    $deleteFavoritStmt->bindParam(':id_plant', $id_plant);
    $deleteFavoritStmt->execute();

    // Delete the plant from the plant table
    $deletePlantSql = "DELETE FROM plant WHERE id_plant = :id_plant";
    $deletePlantStmt = $pdo->prepare($deletePlantSql);
    $deletePlantStmt->bindParam(':id_plant', $id_plant);
    $deletePlantStmt->execute();

    header("location: plantes.php");
}
?>

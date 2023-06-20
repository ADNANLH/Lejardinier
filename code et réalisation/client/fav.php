<?php
require "../connection.php";

$id_client = isset($_GET['id_client']) ? $_GET['id_client'] : '';
$id_plant = isset($_GET['id_plant']) ? $_GET['id_plant'] : '';

if (isset($id_client) && isset($id_plant)) {
    $select = "SELECT * FROM favorit WHERE id_client = :id_client AND id_plant = :id_plant";
    $stmt = $pdo->prepare($select);
    $stmt->bindParam(':id_client', $id_client);
    $stmt->bindParam(':id_plant', $id_plant);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $delete = "DELETE FROM favorit WHERE id_client = :id_client AND id_plant = :id_plant";
        $stmt = $pdo->prepare($delete);
        $stmt->bindParam(':id_client', $id_client);
        $stmt->bindParam(':id_plant', $id_plant);
        $stmt->execute();
    } else {
        $insert = "INSERT INTO favorit (id_client, id_plant) VALUES (:id_client, :id_plant)";
        $stmt = $pdo->prepare($insert);
        $stmt->bindParam(':id_client', $id_client);
        $stmt->bindParam(':id_plant', $id_plant);
        $stmt->execute();
    }
}
?>

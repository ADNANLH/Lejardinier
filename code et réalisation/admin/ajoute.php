<html lang="en">
<?php

require "../connection.php";
require "./navbar.php";

?>
<body>


    <div class="card-body">
        <h1 class="title">Ajouter une plante</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="inputs">
                
                <label for="">Nom</label>
                <input type="text" name="nom" placeholder="Nom de plante">
                
            </div>
            
            <div class="inputs">
                
                <label for="">Prix</label>
                <input type="number" name="prix" placeholder="Prix">
                
            </div>
            <div class="inputs">
                <label for="">Description</label>
                <textarea name="description" placeholder="La description de cette plante"></textarea>
            </div>
            
            
            <div class="inputs">

                <label for="">Humidité</label>
                <select name="humidite" class="form-control form-select border-0 py-3">
                    <option value="">Humidité</option>
                    <option value="faible">Faible</option>
                    <option value="moderee">Modérée</option>
                    <option value="elevee">Élevée</option>
                </select>
            </div>
            <div class="inputs">
                
                <label for="">Arrosage</label>
                <select name="arrosage" class="form-control form-select border-0 py-3">
                    <option value="">Arrosage</option>
                    <option value="quotidien">Quotidien</option>
                    <option value="hebdomadaire">Hebdomadaire</option>
                    <option value="mensuel">Mensuel</option>
                </select>                
            </div>
            <div class="inputs">
                
                <label for="">Lumière</label>
                <select name="lumiere" class="form-control form-select border-0 py-3">
                    <option value="">Lumière</option>
                    <option value="plein_soleil">Plein soleil</option>
                    <option value="mi_ombre">Mi-ombre</option>
                    <option value="ombre">Ombre</option>
                </select>
                
            </div>
            <div class="inputs">
                
                <label for="">Quantité</label>
                <input type="number" name="quantite" placeholder="0">
                <label for="">Image</label>
                <input type="file" class="upload-input" name="image" placeholder="Ajouter une image">
                
            </div>
            
            <?php
            if (!empty($_SESSION['error'])) {
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
            ?>



<div class="p-t-30">
    <button class="btn btn--radius btn--green" name="ajouter" type="submit">Ajouter</button>
</div>

</form>

<?php 

if(isset($_POST['ajouter'])){
    
    $nom = $_POST['nom'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $description = $_POST['description'] ?? '';
    $lumiere = $_POST['lumiere'] ?? '';
    $arrosage = $_POST['arrosage'] ?? '';
    $humidite = $_POST['humidite'] ?? '';
    $quantite = $_POST['quantite'] ?? '';
    
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Veuillez sélectionner une image.</div>";
    } else {
      
        $image = $_FILES['image']['tmp_name'];
    
        $query = "SELECT * FROM plant WHERE nom_plant = :nom";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->execute();
    
        if (!isset($nom) || !isset($prix) || !isset($description) || !isset($lumiere) || !isset($arrosage) || !isset($humidite) || !isset($quantite)) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Tous les champs sont obligatoires.</div>";
        } elseif ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Vous avez déjà une plante avec ce nom.</div>";
        } else {
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $filename = $_FILES["image"]["name"];
                $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
                $filename1 = uniqid('', true) . ".$fileExtension";
                $folder = "../images/" . $filename1;
                move_uploaded_file($image, $folder);
    
                $insert = "INSERT INTO plant (nom_plant, image, prix, description, lumiere, arrosage, humidite, quantite) 
                    VALUES (:nom, :image, :prix, :description, :lumiere, :arrosage, :humidite, :quantite)";
                $stmt = $pdo->prepare($insert);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':image', $filename1);
                $stmt->bindParam(':prix', $prix);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':lumiere', $lumiere);
                $stmt->bindParam(':arrosage', $arrosage);
                $stmt->bindParam(':humidite', $humidite);
                $stmt->bindParam(':quantite', $quantite);
                $stmt->execute();
                // header("location: plantes.php");

            } else {
                $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Une erreur s'est produite lors du téléchargement de l'image.</div>";
            }
        }
    }
}
?>

    
        
         
        
    </div>
</body>



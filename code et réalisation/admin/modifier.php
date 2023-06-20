<?php
    session_start();
    require('../connection.php');
    $id_plant = isset($_GET['id_plant']) ? $_GET['id_plant'] : null;
    require('./navbar.php');
?>

<body>
    <?php
        $sql = "SELECT * FROM plant WHERE id_plant = :id_plant";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_plant', $id_plant);
        $stmt->execute();

        // Fetch the plant information from the result set
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // Handle any errors
            echo "Erreur lors de la récupération des informations de plante: " . $stmt->errorInfo();
        }
    ?>

   
        <div class="card-body">
            <h1 class="title">Mon profile</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="inputs">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?php echo $row['nom_plant'] ?>">
                </div>
                <div class="inputs">
                    <label for="image">Image</label>
                    <?php if (!empty($row['image'])) : ?>
                        <img src="../images/<?php echo $row['image']; ?>" width="90px" alt="Plant Image">
                    <?php endif; ?>
                    <input type="file" class="upload-input" id="image" name="image">
                </div>
                <div class="inputs">
                    <label for="prix">Prix</label>
                    <input type="text" id="prix" name="prix" value="<?php echo $row['prix']; ?>">
                </div>
                <div class="inputs">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="<?php echo $row['description'] ?>"><?php echo $row['description'] ?></textarea>
                </div>
                <div class="inputs">
                    <label for="humidite">Humidité</label>
                    <select id="humidite" name="humidite" class="form-control form-select border-0 py-3">
                        <option value="<?php echo $row['humidite']; ?>"><?php echo $row['humidite']; ?></option>
                        <option value="faible">Faible</option>
                        <option value="moderee">Modérée</option>
                        <option value="elevee">Élevée</option>
                    </select>
                </div>
                <div class="inputs">
                    <label for="arrosage">Arrosage</label>
                    <select id="arrosage" name="arrosage" class="form-control form-select border-0 py-3">
                        <option value="<?php echo $row['arrosage']; ?>"><?php echo $row['arrosage']; ?></option>
                        <option value="quotidien">Quotidien</option>
                        <option value="hebdomadaire">Hebdomadaire</option>
                        <option value="mensuel">Mensuel</option>
                    </select>
                </div>
                <div class="inputs">
                    <label for="lumiere">Lumière</label>
                    <select id="lumiere" name="lumiere" class="form-control form-select border-0 py-3">
                        <option value="<?php echo $row['lumiere']; ?>"><?php echo $row['lumiere']; ?></option>
                        <option value="plein_soleil">Plein soleil</option>
                        <option value="mi_ombre">Mi-ombre</option>
                        <option value="ombre">Ombre</option>
                    </select>
                </div>
                <div class="inputs">
                    <label for="quantite">Quantité</label>
                    <input type="text" id="quantite" name="quantite" value="<?php echo $row['quantite'] ?>">
                </div>

                <?php
                    if (!empty($_SESSION['error'])) {
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    }
                    if (!empty($_SESSION['success'])) {
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    }
                ?>

                <button class="btn btn--radius btn--green" type="submit" name="submit">Modifier</button>
            </form>
        </div>
    

    <?php
        $nom = $row['nom_plant'];
        $prix = $row['prix'];
        $description = $row['description'];
        $lumiere = $row['lumiere'];
        $arrosage = $row['arrosage'];
        $humidite = $row['humidite'];
        $quantite = $row['quantite'];
        $image = $row['image'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] !== '' ? $_POST['nom'] : $row['nom_plant'];
            $prix = $_POST['prix'] !== '' ? $_POST['prix'] : $row['prix'];
            $description = $_POST['description'] !== '' ? $_POST['description'] : $row['description'];
            $lumiere = $_POST['lumiere'] !== '' ? $_POST['lumiere'] : $row['lumiere'];
            $arrosage = $_POST['arrosage'] !== '' ? $_POST['arrosage'] : $row['arrosage'];
            $humidite = $_POST['humidite'] !== '' ? $_POST['humidite'] : $row['humidite'];
            $quantite = $_POST['quantite'] !== '' ? $_POST['quantite'] : $row['quantite'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $image = $_FILES['image']['tmp_name'];
                $filename = $_FILES["image"]["name"];
                $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
                $filename1 = uniqid('', true) . ".$fileExtension";
                $folder = "../images/" . $filename1;

                // Move the uploaded file to the destination folder
                if (move_uploaded_file($image, $folder)) {
                    $image = $filename1;
                } else {
                    // Handle file upload error
                    $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>Erreur lors du téléchargement de l'image.</div>";
                }
            }

            $updateQuery = "UPDATE plant SET nom_plant = :nom, image = :image, prix = :prix, description = :description, lumiere = :lumiere, arrosage = :arrosage, humidite = :humidite, quantite = :quantite WHERE id_plant = :id_plant";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':lumiere', $lumiere);
            $stmt->bindParam(':arrosage', $arrosage);
            $stmt->bindParam(':humidite', $humidite);
            $stmt->bindParam(':quantite', $quantite);
            $stmt->bindParam(':id_plant', $id_plant);

            if ($stmt->execute()) {
                // Update successful, display success message
                $_SESSION['success'] = "<div class='success alert alert-success' role='alert'>Modification réussie.</div>";
            } else {
                // Update failed, display error message
                $_SESSION['error'] = "<div class='error alert alert-danger' role='alert'>La modification a échoué.</div>";
            }
        }
    ?>

</body>
</html>

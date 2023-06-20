-- Table: Plant
CREATE TABLE Plant (
  id_plant INT PRIMARY KEY AUTO_INCREMENT,
  nom_plant VARCHAR(255),
  image VARCHAR(255),
  prix DECIMAL(10, 2),
  description Text,
  lumiere VARCHAR(255),
  arrosage VARCHAR(255),
  humidite VARCHAR(255),
  quantite INT
);

-- Table: Client
CREATE TABLE Client (
  id_client INT PRIMARY KEY AUTO_INCREMENT ,
  nom_client VARCHAR(255),
  cin VARCHAR(255),
  email VARCHAR(255)
  password VARCHAR(255)
);

-- Table: Commande
CREATE TABLE Commande (
  id_commande INT PRIMARY KEY AUTO_INCREMENT,
  date DATE,
  id_client INT,
  etat VARCHAR(50),
  FOREIGN KEY (id_client) REFERENCES Client(id_client)
);
-- Table: Ligne_commande
CREATE TABLE Ligne_commande (
  id_ligne_cmd INT PRIMARY KEY AUTO_INCREMENT,
  id_commande INT,
  id_plant INT, 
  FOREIGN KEY (id_commande) REFERENCES Commande(id_commande),
  FOREIGN KEY (id_plant) REFERENCES Plant(id_plant)
);

-- Table: Favorit
CREATE TABLE Favorit (
  id_favorit INT PRIMARY KEY AUTO_INCREMENT,
  id_client INT,
  id_plant INT,
  FOREIGN KEY (id_client) REFERENCES Client(id_client),
  FOREIGN KEY (id_plant) REFERENCES Plant(id_plant)
);

-- Inserting data into Plant table
INSERT INTO Plant (id_plant, nom_plant, prix, description, lumiere, arrosage, humidite, quantite)
VALUES
  (1, 'Rose', 9.99, 'Requires full sun', 'Full sun', 'Regular', 'Medium', 5),
  (2, 'Lavender', 12.99, 'Thrives in well-drained soil', 'Full sun', 'Regular', 'Low', 8),
  (3, 'Snake Plant', 19.99, 'Tolerates low light conditions', 'Partial shade', 'Low', 'High', 3),
  (4, 'Fiddle Leaf Fig', 24.99, 'Requires bright indirect light', 'Partial shade', 'Regular', 'Medium', 10),
  (5, 'Succulent Mix', 7.99, 'Drought-tolerant plants', 'Full sun', 'Low', 'Low', 2),
  (6, 'Spider Plant', 6.99, 'Easy to care for and propagate', 'Partial shade', 'Regular', 'High', 4),
  (7, 'Peace Lily', 14.99, 'Prefers low light conditions', 'Full shade', 'Regular', 'High', 6),
  (8, 'Pothos', 8.99, 'Thrives in a variety of light conditions', 'Partial shade', 'Regular', 'Medium', 7),
  (9, 'Jade Plant', 11.99, 'Requires bright light', 'Full sun', 'Regular', 'Low', 9),
  (10, 'Bamboo Palm', 17.99, 'Thrives in indirect light', 'Partial shade', 'Regular', 'High', 1);

-- Inserting data into Client table
INSERT INTO Client (id_client, nom_client, cin, email, password)
VALUES
  (1, 'John Doe', '123 Main St', '1234567890', 'johndoe@example.com'),
  (2, 'Jane Smith', '456 Elm St', '0987654321', 'janesmith@example.com'),
  (3, 'Mike Johnson', '789 Oak St', '1112223333', 'mikejohnson@example.com');



-- Insertion des données dans la table Commande
INSERT INTO Commande (id_commande, date, id_client, etat)
VALUES
  (1, '2023-05-01', 1, 'En attente'),
  (2, '2023-05-02', 2, 'En cours de traitement'),
  (3, '2023-05-03', 3, 'Terminée');


-- Inserting data into Ligne_commande table
INSERT INTO Ligne_commande (id_ligne_cmd, id_commande, id_plant, qnt_unt)
VALUES
  (1, 1, 2, 3),
  (2, 1, 5, 2),
  (3, 2, 3, 1),
  (4, 3, 1, 5);

-- Inserting data into Favorit table
INSERT INTO Favorit (id_favorit, id_client, id_plant)
VALUES
  (1, 1, 3),
  (2, 1, 6),
  (3, 2, 1),
  (4, 3, 5);

DELIMITER //

CREATE TRIGGER update_command_status_trigger
AFTER INSERT ON Commande
FOR EACH ROW
BEGIN
    IF NEW.etat = 'en attente' THEN
        -- Calculate the date three days ago
        SET @threeDaysAgo = DATE_SUB(CURDATE(), INTERVAL 3 DAY);
        
        -- Update the status of the command to 'annulée' if it's still 'en attente' after three days
        UPDATE Commande
        SET etat = 'annulée'
        WHERE id_commande = NEW.id_commande AND etat = 'en attente' AND date <= @threeDaysAgo;
    END IF;
END //

DELIMITER ;

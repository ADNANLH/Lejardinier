<?php
    $host = 'localhost';
    $dbname = 'jardinier';
    $username = 'root';
    $password = '';   
    $dsn = "mysql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);

 ?>

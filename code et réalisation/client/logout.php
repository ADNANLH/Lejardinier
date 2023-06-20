<?php

session_start();

// Get the client's ID from the URL
$id_client = isset($_GET['id_client']) ? $_GET['id_client'] : '';

session_destroy();

// Redirect the user to the desired page
header("Location: index.php"); // Replace "login.php" with your desired page
exit();
?>

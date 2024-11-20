<?php
$host = 'localhost';
$dbname = 'professor';  // Change to professor job application database
$username = 'root';  // Change this as needed
$password = '';  // Change this as needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>

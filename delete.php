<?php
session_start();
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $response = deleteProfessor($pdo, $id);
    $_SESSION['message'] = $response['message'];
    header('Location: index.php');
    exit();
} else {
    echo "Professor ID not provided.";
}
?>

<?php
session_start();
include("../config/db.php");

// Allow only admin users
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    die("Access Denied");
}

// Validate ID
if(!isset($_GET['id']) || !is_numeric($_GET['id']))
{
    die("Invalid Post ID");
}

$id = $_GET['id'];

// Prepared Statement
$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);

if($stmt->execute())
{
    header("Location: read.php");
    exit();
}
else
{
    echo "Unable to delete post.";
}

$stmt->close();
$conn->close();
?>
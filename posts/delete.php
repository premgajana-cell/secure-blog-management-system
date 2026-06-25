<?php
include("../config/db.php");

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM posts WHERE id=$id");

header("Location: read.php");
exit();
?>
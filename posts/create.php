<?php
include("../config/db.php");

if(isset($_POST['save']))
{
    $title = $_POST['title'];
    $content = $_POST['content'];

    mysqli_query($conn,
        "INSERT INTO posts(title, content)
         VALUES('$title', '$content')");

    header("Location: read.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <style>
        /* Create Post Page */
.create-wrapper {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #4facfe, #8e44ad);
}

.create-card {
    width: 500px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(12px);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0px 8px 30px rgba(0,0,0,0.25);
    text-align: center;
}

.create-card h1 {
    color: white;
    margin-bottom: 10px;
    font-size: 38px;
}

.create-card p {
    color: #f1f1f1;
    margin-bottom: 30px;
}

.create-card input,
.create-card textarea {
    width: 100%;
    padding: 16px;
    margin: 12px 0;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    box-sizing: border-box;
}

.create-card textarea {
    height: 140px;
    resize: none;
}

.create-card button {
    width: 100%;
    padding: 16px;
    margin-top: 15px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    color: white;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.create-card button:hover {
    transform: scale(1.03);
}
    </style>
</head>
<body>

<div class="create-wrapper">
    <div class="create-card">
        <h1>Create New Post</h1>
        <p>Add your title and content below</p>

        <form method="POST">
            <input type="text" name="title" placeholder="Enter Post Title" required>

            <textarea name="content" placeholder="Write your content here..." required></textarea>

            <button name="save">Save Post</button>
        </form>
    </div>
</div>

</body>
</html>
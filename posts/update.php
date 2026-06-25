<?php
include("../config/db.php");

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM posts WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $title = $_POST['title'];
    $content = $_POST['content'];

    mysqli_query($conn,
        "UPDATE posts
         SET title='$title', content='$content'
         WHERE id=$id");

    header("Location: read.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Post</title>
    <style>
    /* Update Post */
.update-wrapper {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #4facfe, #8e44ad);
}

.update-card {
    width: 550px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(15px);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0px 8px 25px rgba(0,0,0,0.3);
    text-align: center;
}

.update-card h1 {
    color: white;
    font-size: 42px;
    margin-bottom: 10px;
}

.update-card p {
    color: #f2f2f2;
    margin-bottom: 25px;
}

.update-card input,
.update-card textarea {
    width: 100%;
    padding: 16px;
    margin: 12px 0;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    box-sizing: border-box;
}

.update-card textarea {
    height: 150px;
    resize: none;
}

.update-card button {
    width: 100%;
    padding: 16px;
    margin-top: 15px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(45deg, #0072ff, #c850c0);
    color: white;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.update-card button:hover {
    transform: scale(1.03);
}

.back-btn {
    display: inline-block;
    margin-top: 20px;
    color: white;
    text-decoration: none;
    font-weight: bold;
    font-size: 18px;
}
        </style>

<div class="update-wrapper">
    <div class="update-card">

        <h1>Update Post</h1>
        <p>Edit your post details below</p>

        <form method="POST">
            <input type="text" name="title"
                value="<?php echo $row['title']; ?>" required>

            <textarea name="content" required><?php echo $row['content']; ?></textarea>

            <button name="update">Update Post</button>
        </form>

        <a href="read.php" class="back-btn">← Back to Posts</a>

    </div>
</div>

</body>
</html>
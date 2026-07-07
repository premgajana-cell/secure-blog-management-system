<?php
session_start();
include("../config/db.php");

$message = "";

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

// Get existing post using prepared statement
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if(!$row)
{
    die("Post not found");
}

if(isset($_POST['update']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Form Validation
    if(empty($title) || empty($content))
    {
        $message = "All fields are required";
    }
    else
    {
        // Update using prepared statement
        $update = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
        $update->bind_param("ssi", $title, $content, $id);

        if($update->execute())
        {
            header("Location: read.php");
            exit();
        }
        else
        {
            $message = "Unable to update post";
        }

        $update->close();
    }
}

$stmt->close();
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
        <?php if(!empty($message)) { ?>
<div style="
    background:#ffe5e5;
    color:#d8000c;
    padding:12px;
    margin-bottom:15px;
    border-radius:8px;
    font-weight:bold;
">
    <?php echo htmlspecialchars($message); ?>
</div>
<?php } ?>

        <form method="POST">
            <input type="text" name="title"
                value="<?php echo htmlspecialchars($row['title']); ?>" required>

            <textarea name="content" required><?php echo htmlspecialchars($row['content']); ?></textarea>

            <button name="update">Update Post</button>
        </form>

        <a href="read.php" class="back-btn">← Back to Posts</a>

    </div>
</div>

</body>
</html>
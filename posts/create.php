<?php
session_start();
include("../config/db.php");

$message = "";

// Allow only admin users
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    die("Access Denied");
}

if(isset($_POST['save']))
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
        // Prepared Statement
        $stmt = $conn->prepare("INSERT INTO posts(title, content) VALUES(?, ?)");
        $stmt->bind_param("ss", $title, $content);

        if($stmt->execute())
        {
            header("Location: read.php");
            exit();
        }
        else
        {
            $message = "Unable to save post";
        }

        $stmt->close();
    }
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
            <input type="text" name="title" placeholder="Enter Post Title" required>

            <textarea name="content" placeholder="Write your content here..." required></textarea>

            <button name="save">Save Post</button>
        </form>
    </div>
</div>

</body>
</html>
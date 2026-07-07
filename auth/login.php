<?php
session_start();
include("../config/db.php");

$message = "";

if(isset($_POST['login']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Form Validation
    if(empty($username) || empty($password))
    {
        $message = "All fields are required";
    }
    else
    {
        // Prepared Statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            $user = $result->fetch_assoc();

            if(password_verify($password, $user['password']))
            {
                $_SESSION['user'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: ../posts/read.php");
                exit();
            }
            else
            {
                $message = "Invalid username or password";
            }
        }
        else
        {
            $message = "Invalid username or password";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #4facfe, #8e44ad);
    height: 100vh;
}

.login-container {
    width: 900px;
    height: 500px;
    margin: 70px auto;
    display: flex;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0px 10px 30px rgba(0,0,0,0.3);
}

.left-panel {
    width: 45%;
    background: linear-gradient(135deg, #3a7bd5, #8e44ad);
    color: white;
    padding: 100px 40px;
}

.left-panel h1 {
    font-size: 40px;
}

.left-panel p {
    font-size: 20px;
    margin-top: 20px;
}

.right-panel {
    width: 55%;
    background: white;
    text-align: center;
    padding: 70px 50px;
}

.right-panel h2 {
    font-size: 40px;
    margin-bottom: 40px;
}

input {
    width: 85%;
    padding: 15px;
    margin: 15px 0;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 16px;
}

button {
    width: 90%;
    padding: 15px;
    margin-top: 20px;
    background: linear-gradient(45deg, #3a7bd5, #8e44ad);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 20px;
    cursor: pointer;
}

button:hover {
    opacity: 0.9;
}

a {
    color: #8e44ad;
    text-decoration: none;
    font-weight: bold;
}
</style>
</head>
<body>

<div class="login-container">

    <div class="left-panel">
        <h1>My CRUD Application</h1>
        <p>Securely login to access your posts and manage content.</p>
    </div>

    <div class="right-panel">
        <h2>Login</h2>
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
            <input type="text" name="username" placeholder="Username" required>

            <input type="password" name="password" placeholder="Password" required>

            <button name="login">Login</button>
        </form>

        <p>Don't have an account?</p>
        <a href="register.php">Register</a>
    </div>

</div>

</body>
</html>
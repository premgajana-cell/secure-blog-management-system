<?php
session_start();
include("../config/db.php");

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn,
        "SELECT * FROM users WHERE username='$username'"
    );

    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password, $user['password']))
    {
        $_SESSION['user'] = $username;
        header("Location: ../posts/read.php");
        exit();
    }
    else
    {
        echo "<script>alert('Invalid Login');</script>";
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
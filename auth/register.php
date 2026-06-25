<?php
include("../config/db.php");

if(isset($_POST['register']))
{
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn,
        "INSERT INTO users(username,password)
         VALUES('$username','$password')");

    echo "<script>alert('Registration Successful');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
    /* Register Page */
.register-wrapper {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #4facfe, #8e44ad);
}

.register-card {
    width: 450px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(15px);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0px 8px 25px rgba(0,0,0,0.3);
    text-align: center;
}

.register-card h1 {
    color: white;
    font-size: 40px;
    margin-bottom: 10px;
}

.register-card p {
    color: #f1f1f1;
    margin-bottom: 25px;
}

.register-card input {
    width: 100%;
    padding: 16px;
    margin: 12px 0;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    box-sizing: border-box;
}

.register-card button {
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

.register-card button:hover {
    transform: scale(1.03);
}

.login-link {
    margin-top: 20px;
}

.login-link a {
    color: yellow;
    font-weight: bold;
    text-decoration: none;
}
</style>
</head>
<body>

<div class="register-wrapper">
    <div class="register-card">

        <h1>Create Account</h1>
        <p>Register to access your CRUD Application</p>

        <form method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>

            <input type="password" name="password" placeholder="Enter Password" required>

            <button name="register">Register</button>
        </form>

        <p class="login-link">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </div>
</div>

</body>
</html>
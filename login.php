<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Credentials do not match.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
<div class="form-container">
    <h2>Login</h2>
    <form method="POST">
      <label>Username</label>
      <input type="text" name="username" placeholder="Enter your username" required>
      
      <label>Password</label>
      <input type="password" name="password" placeholder="Enter your password" required>
      
      <input type="submit" value="Login" class="btn">
    </form>
    
    <div style="margin-top: 20px; color: rgba(255, 255, 255, 0.8);">
        Don't have an account? <a href="register.php" style="color: #4ade80; text-decoration: none; font-weight: 600;">Register</a>
    </div>

    <?php if (!empty($error)) { ?>
      <p style="color: #ef4444; background: rgba(239, 68, 68, 0.1); margin-top: 15px;"><?php echo $error; ?></p>
    <?php } ?>
</div>
</body>
</html>
<?php
include 'db.php';
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    try {
        if ($stmt->execute()) {
            $success = "User registered successfully.";
        }
    } catch (mysqli_sql_exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            if (strpos($e->getMessage(), "'username'") !== false) {
                $error = "This username is already taken. Please choose another.";
            } elseif (strpos($e->getMessage(), "'email'") !== false) {
                $error = "This email is already registered. Please use another.";
            } else {
                $error = "Duplicate entry detected.";
            }
        } else {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
<div class="form-container">
    <h2>Register</h2>
    <form method="POST">
      <label>Username</label>
      <input type="text" name="username" placeholder="Choose a username" required>
      
      <label>Email</label>
      <input type="email" name="email" placeholder="Enter your email" required>
      
      <label>Password</label>
      <input type="password" name="password" placeholder="Create a password" required>
      
      <input type="submit" value="Register" class="btn">
    </form>

    <div style="margin-top: 20px; color: rgba(255, 255, 255, 0.8);">
        Already have an account? <a href="login.php" style="color: #4ade80; text-decoration: none; font-weight: 600;">Login</a>
    </div>

    <?php if (!empty($error)) { ?>
      <p style="color: #ef4444; background: rgba(239, 68, 68, 0.1); margin-top: 15px; padding: 12px; border-radius: 10px;"><?php echo $error; ?></p>
    <?php } ?>
    <?php if (!empty($success)) { ?>
      <p style="color: #4ade80; background: rgba(74, 222, 128, 0.1); margin-top: 15px; padding: 12px; border-radius: 10px;"><?php echo $success; ?></p>
    <?php } ?>
</div>
</body>
</html>
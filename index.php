<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="welcome-page">
    <div class="welcome-container">
        <h1>WELCOME</h1>
        <p>Hello, <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</p>
        <p style="font-size: 16px; color: rgba(255, 255, 255, 0.6);">You have successfully logged in.</p>
        <div style="display: flex; gap: 15px; margin-top: 30px; justify-content: center;">
            <a href="dashboard.php" class="btn add-btn">Dashboard</a>
            <a href="logout.php" class="btn back-btn">Logout</a>
        </div>
    </div>
</body>
</html>
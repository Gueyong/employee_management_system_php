<?php
session_start();

// If admin is already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: admin/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Administrator Login</h2>
        
        <?php
        // Display error message if login failed
        if (isset($_GET['error'])) {
            echo "<div class='error'>Invalid username or password</div>";
        }
        ?>
        
        <form action="admin_login_process.php" method="POST">
            <label>Username</label>
            <input type="text" name="username" required placeholder="Enter your username">
            
            <label>Password</label>
            <input type="password" name="password" required placeholder="Enter your password">
            
            <button type="submit">Login</button>
            
            <div class="link">
                <a href="index.php">← Back to Home</a>
            </div>
        </form>
    </div>
</body>
</html>
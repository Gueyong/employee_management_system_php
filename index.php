<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Employee Management System</h1>
        <p style="text-align: center; color: #666; margin-bottom: 30px;">
            Welcome! Please select your login type
        </p>
       
        <div class="card">
            <h3>Administrator Login</h3>
            <p style="color: #666; margin: 10px 0 15px 0;">
                For system administrators to manage employees and validate presence
            </p>
            <button onclick="window.location.href='admin_login.php'">
                Admin Login
            </button>
        </div>


        <div class="card">
            <h3>Employee Login</h3>
            <p style="color: #666; margin: 10px 0 15px 0;">
                For employees to mark presence and view their logs
            </p>
            <button onclick="window.location.href='employee_login.php'">
                Employee Login
            </button>
        </div>
    </div>
</body>
</html>


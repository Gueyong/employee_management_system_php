<?php
require "../includes/db.php";
require "../includes/functions.php";
require "../includes/session_check.php";

checkAdminAuth(); // Check if the user is an admin


$total_employee_query = "SELECT COUNT(*) AS count FROM employees WHERE status = 'active'";
$total_employees = $conn->query($total_employee_query)->fetch_assoc()['count'];

$pending_validation_query = " SELECT COUNT(*) AS count FROM presence_logs WHERE status = 'pending'";
$pending_validations = $conn->query($pending_validation_query)->fetch_assoc()['count'];

$today_presence_query = "SELECT COUNT(*) AS count FROM presence_logs WHERE marked_date = CURDATE()";
$today_presence = $conn->query($today_presence_query)->fetch_assoc()['count'];

$recent_logs_query = "SELECT pl.*, e.first_name, e.last_name, e.employee_id
                      FROM presence_logs pl
                      JOIN employees e ON pl.employee_id=e.id
                      ORDER BY pl.marked_date DESC pl.marked_time DESC 
                      LIMIT 10";

$recent_logs = $conn->query($recent_logs_query);
?>



<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Navigation -->
        <div class="nav">
            <div>
                <strong>Admin Panel</strong> - Welcome, <?php echo $_SESSION['admin_name']; ?>
            </div>
            <div>
                <a href="dashboard.php">Dashboard</a>
                <a href="add_employee.php">Add Employee</a>
                <a href="manage_employees.php">Manage Employees</a>
                <a href="validate_presence.php">Validate Presence</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <h1>Dashboard</h1>

        <!-- Statistics Cards -->
        <div class="stats">
            <div class="stat-card">
                <p>Total Employees</p>
                <h3><?php echo $total_employees; ?></h3>
            </div>
            <div class="stat-card">
                <p>Pending Validations</p>
                <h3><?php echo $pending_validations; ?></h3>
            </div>
            <div class="stat-card">
                <p>Today's Presence</p>
                <h3><?php echo $today_presence; ?></h3>
            </div>
        </div>

        <!-- Recent Presence Logs -->
        <h3>Recent Presence Logs</h3>
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($recent_logs->num_rows > 0): ?>
                    <?php while($log = $recent_logs->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $log['employee_id']; ?></td>
                            <td><?php echo $log['first_name'] . ' ' . $log['last_name']; ?></td>
                            <td><?php echo formatDate($log['marked_date']); ?></td>
                            <td><?php echo formatTime($log['marked_time']); ?></td>
                            <td><?php echo getStatusBadge($log['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No presence logs yet</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
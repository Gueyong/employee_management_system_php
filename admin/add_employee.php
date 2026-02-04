<?php
/**
 * Add Employee Page
 * Admin can create new employee accounts with department and salary
 */

require "../includes/db.php";
require "../includes/functions.php";
require "../includes/session_check.php";

// Check if admin is logged in
checkAdminAuth();

$success = "";
$error = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and sanitize inputs
    $first_name = sanitize($_POST['first_name']);
    $last_name = sanitize($_POST['last_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $department_id = $_POST['department_id'] ? (int)$_POST['department_id'] : NULL;
    $daily_rate = (float)$_POST['daily_rate'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate password match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        
        // Generate unique employee ID
        do {
            $employee_id = generateEmployeeId();
        } while (employeeIdExists($conn, $employee_id));
        
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert into database
        $sql = "INSERT INTO employees (employee_id, first_name, last_name, email, phone, password, department_id, daily_rate, hire_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURDATE())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssid", $employee_id, $first_name, $last_name, $email, $phone, $hashed_password, $department_id, $daily_rate);
        
        if ($stmt->execute()) {
            $success = "Employee created successfully! Employee ID: <strong>$employee_id</strong><br>Password: <strong>$password</strong> (Share this with employee)";
        } else {
            $error = "Error creating employee: " . $stmt->error;
        }
    }
}

// Get all departments
$departments = getAllDepartments($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Navigation -->
        <div class="nav">
            <div>
                <strong>Admin Panel</strong> - Add Employee
            </div>
            <div>
                <a href="dashboard.php">Dashboard</a>
                <a href="add_employee.php">Add Employee</a>
                <a href="manage_employees.php">Manage Employees</a>
                <a href="departments.php">Departments</a>
                <a href="validate_presence.php">Validate Presence</a>
                <a href="salary_reports.php">Salary Reports</a>
                <a href="profile.php">My Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <h2>Add New Employee</h2>
        
        <?php 
        if ($success) echo "<div class='success'>$success</div>";
        if ($error) echo "<div class='error'>$error</div>";
        ?>
        
        <form method="POST" action="">
            <h3>Personal Information</h3>
            
            <label>First Name *</label>
            <input type="text" name="first_name" required>
            
            <label>Last Name *</label>
            <input type="text" name="last_name" required>
            
            <label>Email *</label>
            <input type="email" name="email" required>
            
            <label>Phone</label>
            <input type="text" name="phone" placeholder="e.g. +1234567890">
            
            <h3>Employment Details</h3>
            
            <label>Department</label>
            <select name="department_id">
                <option value="">-- Select Department --</option>
                <?php while($dept = $departments->fetch_assoc()): ?>
                    <option value="<?php echo $dept['id']; ?>">
                        <?php echo $dept['department_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <label>Daily Rate (Salary per day) *</label>
            <input type="number" name="daily_rate" step="0.01" value="0.00" required>
            <small style="color: #666;">Amount employee earns per validated presence day</small>
            
            <h3>Account Credentials</h3>
            
            <label>Password *</label>
            <input type="password" name="password" required>
            
            <label>Confirm Password *</label>
            <input type="password" name="confirm_password" required>
            
            <button type="submit">Create Employee</button>
            <button type="button" class="btn-secondary" onclick="window.location.href='dashboard.php'">
                Cancel
            </button>
        </form>
    </div>
</body>
</html>
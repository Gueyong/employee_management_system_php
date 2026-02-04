<?php 

session_start();
require "includes/db.php";
require "includes/functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = sanitize($_POST["username"]);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username =? LIMIT 1";
    $stmt = $conn -> prepare ($sql);
    $stmt -> bind_param("s",$username);
    $stmt -> execute();

    $result = $stmt -> get_result();
    $admin = $result -> fetch_assoc();

    if($admin && password_verify($password,$admin['password'])){
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_name'] = $admin['full_name'];

        header("Location: admin/dashboard.php");
        exit();
    } else{
        header("Location admin_login.php?error=1.php");
        exit();
    }

}else {
    header("Location: admin_login.php"); //redirect to login page
}

?>

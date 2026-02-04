<?php
if (session_status() ===PHP_SESSION_NONE){
    session_start();
}

function checkAdminAuth(){
    if (!isset($_SESSION['admin_id'])){
        header("Location: ../admin_login.php");
        exit();
    }
}

function checkEmployeeAuth(){
    if (!isset($_SESSION['employee_id'])){
        header("Location: ../employee_login.php");
        exit();
    }
}
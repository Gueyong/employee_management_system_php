<?php

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function formatDate($date){

    return date('M d, Y', strtotime($date));
}

function formatTime($time){
    return date('h:i A', strtotime($time));
}


function getStatusBadge($status){
    $badges = [
        'pending' => '<span class="badge badge-pending "> Pending</span>',
        'validated ' => '<span class ="badge badge-validated">Validates</span>',
        'rejected' => '<span class="badge badge-rejected">Rejected</span>'
    ];
    return $badges[$status] ?? $badges;
}

function getEmployeeById($conn, $id){
    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function generateEmployeeId(){
    return "EMP" . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

function employeeIdExits($conn, $employee_id){
    $sql = "SELECT id FROM employees WHERE employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}
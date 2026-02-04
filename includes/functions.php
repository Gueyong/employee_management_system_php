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

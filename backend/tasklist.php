<?php

require_once 'connection.php';
require_once 'login.php';
require_once 'task_actions.php';

if(isset($_SESSION['session_username'])){
    $userName = $_SESSION['session_username'];
}else{
    $message = 'Auth Error';
    $location = $_SERVER['HTTP_HOST'].'/front/login_page.php';

    messageReturn($message, $location);
}

if(isset($_POST['action'])){
    $conn = connectDB();
    $userId = $_SESSION['user_id'];

    switch ($_POST['action']){
        case "addTask":
            addTask(htmlspecialchars($_POST['taskText']), $conn, $userId);
            break;
        case "removeAll":
            removeAll($conn, $userId);
            break;
        case "readyAll":
            readyAll($conn, $userId);
            break;
        case "changeStatus":
            changeStatus($_POST['taskId'], $conn, $userId);
            break;
        case "deleteTask":
            deleteTask($_POST['taskId'], $conn, $userId);
    }
}





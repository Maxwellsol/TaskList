<?php
session_start();
require_once 'connection.php';

if(isset($_POST["login"])){
    $conn = connectDB();
    if(!empty($_POST['login']) && !empty($_POST['password'])) {

        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
        $sql = sprintf('SELECT * FROM `users` WHERE `login`="%s"', $login);
        $loginData = $conn->query($sql);

        if($loginData->rowCount() !=0) {
            $data = $loginData->fetch();
            if(password_verify($password, $data['password'])) {
                authUser($data);
            }else{
                $message = 'Wrong password!';
                $location = $_SERVER['HTTP_HOST'].'/front/login_page.php';
                messageReturn($message, $location);
            }
        }else {
            registerUser($conn, $login, $password);
        }
    }else{
        $location = $_SERVER['HTTP_HOST'].'/front/login_page.php';
        $message = "All fields require!";
        messageReturn($message, $location);
    }
}

function authUser($data){
    $message = "";
    $location = $_SERVER['HTTP_HOST']."/index.php";
    $_SESSION['session_username'] = $data['login'];
    $_SESSION['user_id'] = $data['id'];
    messageReturn($message, $location);
}

function registerUser($conn, $login, $password){
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $userData = ['registerLogin' => $login,
        'registerPassword' => $hash];
    try {
        $sql = "INSERT INTO users (login, password) VALUES (:registerLogin, :registerPassword)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($userData);
        $_SESSION['session_username'] = $login;
        $_SESSION['user_id'] = $conn->lastInsertId();
        $message =  "";
        $location = $_SERVER['HTTP_HOST']."/index.php";
        messageReturn($message, $location);
    } catch (PDOException $e) {
        $location = $_SERVER['HTTP_HOST'].'/front/login_page.php';
        $message = "DatabaseError:".$e->getMessage();
        messageReturn($message, $location);
    }
}

function messageReturn($message, $location){
    if($message!=''){
        header("Location: http://".$location."?msg=".urlencode($message));
    }else{
        header("Location: http://".$location);
    }
}

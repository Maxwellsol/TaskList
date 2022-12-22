<?php
session_start();
unset($_SESSION['session_username']);
session_destroy();
header("Location: http://".$_SERVER['HTTP_HOST'].'/front/login_page.php');


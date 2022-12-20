<?php
session_start();
unset($_SESSION['session_username']);
session_destroy();
header("location: ../front/login_page.php");

<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');
    require('signin_check.php');
    v($_SESSION['signin_user']['id']);

    

 ?>
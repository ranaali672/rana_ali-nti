<?php
session_start();
unset($_SESSION['user']);
setcookie('remember_me','',time()-1,'/');
header('location:login.php');
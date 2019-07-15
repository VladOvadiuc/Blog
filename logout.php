<?php
session_start();
unset($_SESSION['username']);
setcookie("username", "", time() - 3600);
$_SESSION['logout']=true;
header("Location: index.php");
?>
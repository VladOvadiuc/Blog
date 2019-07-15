<?php
session_start();
unset($_SESSION['login']);
if(isset($_COOKIE['username'])) {
	$_SESSION['username'] = $_COOKIE['username'];
	header("Location: hello.php");
}
else if($_SERVER['REQUEST_METHOD'] == 'POST') {
	include_once 'db.php';
	$link=new mysqli(DB_INFO, DB_USER, DB_PASS,DB_NAME);
	if(!$link) {
		die('Connection failed: ' . $mysqli->error());
	}
	// Create and execute a MySQL query
	$sql = "SELECT username,password FROM users WHERE username=?";
	if($stmt = $link->prepare($sql))
	{
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		$stmt->bind_result($user,$psd);
		if($stmt->fetch()) {
				if(sha1($_POST['password'])===$psd){

					$uname = htmlentities($_POST['username']);
					$_SESSION['username'] = $uname;
					$expires = time()+7*24*60*60;
					setcookie('username', $uname, $expires, '/');
					$_SESSION['login']=true;
					header("Location: hello.php");
				}
				else{
					$_SESSION['login']=false;
				}
		}
		else{
			$_SESSION['login']=false;
		}

	$stmt->close();
	}
	$link->close();
	}

?>
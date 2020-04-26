<?php
	session_start();
	if(!isset($_REQUEST['submit']))
		die("access denied");
	print_r($_REQUEST);
	include("db_connection.php");
	$sql = "SELECT * FROM users WHERE user_email = '".$_REQUEST['email']."' AND user_password = '".$_REQUEST['password']."'";
	$result = $conn->query($sql);
	if($result->num_rows == 1)
	{
		$row = $result->fetch_assoc();
		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION['user_name'] = $row['user_name'];
		header("location:../index.php?status=success");
	}
	else
	{
		header("location:../login.php?status=fail");
	}
?>
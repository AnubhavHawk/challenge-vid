<?php
	if(!isset($_REQUEST['submit']))
		die("access denied");
	else
	{
		include("db_connection.php");
		$sql = "INSERT INTO users(user_name, user_email, user_password) VALUES('".$_REQUEST['name']."', '".$_REQUEST['email']."', '".$_REQUEST['password']."' )";
		if($conn->query($sql))
		{
			$l = "location:../login.php?status=success";
			header($l);
		}
		else
		{
			$l = "location:../sign-up.php?s=fail";
			header($l);
		}
	}
?>
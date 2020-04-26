<?php
	include("db_connection.php");
	session_start();
	$review = mysqli_real_escape_string($conn, $_REQUEST['description']);
	// set timezone for india
	date_default_timezone_set('Asia/Kolkata');

	// get the current time  
	$start_date = date('Y-m-d H:i:s');
	$sql = "INSERT INTO review(review, issue_id, user_id, review_date) VALUES('".$review."',".$_REQUEST['issue_id'].", ".$_SESSION['user_id'].", '".$start_date."')";
	if($conn->query($sql))
	{
		$l = "location:../issue.php?id=".$_REQUEST['issue_id']."&status=success";
		header($l);
	}
	else
	{
		$l = "location:../issue.php?id=".$_REQUEST['issue_id']."&status=fail";
		header($l);
	}
?>
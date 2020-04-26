<?php
// echo "<pre>";
	print_r($_REQUEST);
	$sql = "INSERT INTO issues(issue_name, state_id, city_id, location) VALUES('".$_REQUEST['issue']."', ".$_REQUEST['state_id'].", ".$_REQUEST['city_id'].", '".$_REQUEST['location']."')";
	include("db_connection.php");
	if($conn->query($sql))
	{
		$sql = "SELECT issue_id FROM issues WHERE issue_name = '".$_REQUEST['issue']."' AND location = '".$_REQUEST['location']."'";
		// echo $sql."<br>";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$sql = "INSERT INTO issue_img(issue_id, img_name) VALUES('".$row['issue_id']."', 'default.png')";
		// echo $sql ;
		$conn->query($sql);
		$l = "location:../add-image.php?issue=success&id=".$row['issue_id'];

		header($l);
	}
	else
	{
		$l = "location:../index.php?issue=fail";
		header($l);
	}
	// echo $l;
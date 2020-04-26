<?php
	include("db_connection.php");
	$state = $_REQUEST['state_id'];
	$sql = "SELECT city_id, city_name FROM city WHERE state_id = ".$state;
	$result = $conn->query($sql);
	if($result->num_rows > 0)
	{
		$city = '<option value="">Please select city</option>';
		while($row = $result->fetch_assoc())
		{
			$city .= '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';
		}
		echo $city;
	}
	else
	{
		echo "<option value=''>No city found</option>";
	}
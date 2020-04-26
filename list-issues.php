<?php
	include("includes/utility.php");
	include("includes/headers.php");
	include("includes/navbar.php");
	include("includes/db_connection.php");
?>
<div class="row theme-bg-r p-5">
	<div class="col-12">
		<h4>Resolve issues in:  
		<?php
			if(isset($_REQUEST['city']))
			{
				$state_sql = "SELECT state_name, city_name FROM city INNER JOIN state ON city.state_id = state.state_id WHERE city.city_id = ".$_REQUEST['city']." AND state.state_id = ".$_REQUEST['state'];
				$state_result = $conn->query($state_sql);
				$row = $state_result->fetch_assoc();
				echo "<i>".$row['city_name'].", ". $row['state_name']."</i>";
				$i_sql = "SELECT i.issue_id, i.issue_name, i.location, c.city_name, s.state_name FROM issues i INNER JOIN city c ON i.city_id = c.city_id INNER JOIN state s ON i.state_id = s.state_id WHERE i.city_id = ".$_REQUEST['city']." AND i.state_id = ".$_REQUEST['state'];
			}
			else
			{
				?>
				<i>No city selected</i>
				<?php
				$i_sql = "SELECT i.issue_id, i.issue_name, i.location, c.city_name, s.state_name FROM issues i INNER JOIN city c ON i.city_id = c.city_id INNER JOIN state s ON i.state_id = s.state_id LIMIT 25";
			}
		?>
		<img src="<?=baseurl()?>/assets/img/marker.png" width="40px"></h4>
		<form>
			<select class="form-control col-12" id="state" name="state_id">
				<option>Select state / Province</option>
				<?php

					$sql = "SELECT state_id, state_name FROM state";
					$result = $conn->query($sql);
					if($result->num_rows > 0)
					{
						while($row = $result->fetch_assoc())
						{
							?>
							<option value="<?=$row['state_id']?>"><?=$row['state_name']?></option>
							<?php
						}
					}
				?>
			</select>
			<select class="form-control mt-2 col-6" id="city_dropdown" name="city">
				<option>Select city</option>
			</select>
			<button class="btn theme-bg-y mt-2 btn-block" id="find-city">Find</button>
		</form>
	</div>
</div>
<div class="row pb-4">
	<h2 class="mt-5 text-center text-secondary col-12" style="font-family: Arial!important;">People are facing below issues</h2>
	<div class="col-12 text-center text-secondary">
		
	</div>
	<div class="col-12 row p-5 row">
		<?php
		$i_result = $conn->query($i_sql);
		while($i_row = $i_result->fetch_assoc())
		{
			?>
			<div class="col-md-6 col-sm-12 col-lg-3 mb-3 text-center">
				<div class="shadow p-4 rounded">
					<div class="text-center">
						<img src="<?=baseurl()?>/assets/img/issues/default.png" width="100px">
					</div>
					<h6 style="font-family: sans-serif;" class="text-secondary mt-2"><b><?=$i_row['issue_name']?></b></h6>
					<p><b>Location: </b> <?=$i_row['location']?></p>
					<p><?=$i_row['city_name']?> , <?=$i_row['state_name']?> </p>
					<a href="<?=baseurl()?>/issue.php?id=<?=$i_row['issue_id']?> " class="btn theme-bg-r text-white">Send help</a>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<div class="col-12 text-center pl-5 pr-5">
		<a href="#" class="btn theme-text-y shadow-md pl-5 pr-5 border rounded"><b>See more</b></a>
	</div>
</div>
<?php
	include("includes/footer.php");
?>
<script>
	$('#state').on('change', function(){
		var state_id = $(this). children("option:selected"). val();
		$.ajax({
			method:"POST",
			url:"<?=baseurl()?>/includes/fetch_city.php",
			data:{state_id:state_id},
			success:function(data){
				$('#city_dropdown').html(data);
			}
		})
	})
	$('#find-city').click(function(e){
		e.preventDefault();
		var city = $('#city_dropdown').val();
		var state = $('#state').val();
		console.log(city);
		if(city == '' || state == '' || city == ' ' || state == ' ')
			alert("Please select a valid city");
		else
			window.location = "<?=baseurl()?>/list-issues.php?city="+city+"&state="+state;
	})
</script>
<?php
	include("includes/utility.php");
	include("includes/headers.php");
	include("includes/navbar.php");
	include("includes/db_connection.php");
?>
<div class="theme-bg-y">
	<form class="bg-white row rounded p-5 shadow-lg issue-form" method="POST" action="<?=baseurl()?>/includes/add_issue_db.php">
		<h4 class="text-center col-12 mb-3">Publish issue here</h4>
		<select class="col-6 mb-2 form-control" id="state" name="state_id">
			<option>Select state</option>
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
		<select class="col-5 offset-1 mb-2 form-control" id="city_dropdown" name="city_id">
			<option>Select city</option>
		</select>
		<input type="text" name="issue" placeholder="What's it about?" class="form-control mb-2 col-12">
		<input type="text" name="location" placeholder="Enter location" class="form-control mb-2 col-12">
		<input type="submit" name="submit" value="Publish issue" class="btn theme-bg-r text-white mb-2 col-12">
	</form>
</div>
<div class="row pb-4">
	<div class="col-12 mt-5 pt-5"></div>
	<h2 class="mt-5 text-center text-secondary col-12" style="font-family: Arial!important;">People are facing below issues</h2>
	<div class="col-12 row p-5 row">
		<?php
			$sql = "SELECT DISTINCT i.issue_id, i.issue_name, i.location, c.city_name, s.state_name, img.img_name FROM issues i INNER JOIN city c ON i.city_id = c.city_id INNER JOIN state s ON i.state_id = s.state_id INNER JOIN issue_img img ON img.issue_id = i.issue_id GROUP BY i.issue_name";
			$result =$conn->query($sql);
			while($row = $result->fetch_assoc())
			{
				?>
					<div class="col-md-6 col-sm-12 col-lg-3 mb-3 text-center">
						<div class="border shadow-sm p-4 rounded">
							<div class="text-center">
								<img src="<?=baseurl()?>/assets/img/issues/<?=$row['img_name']?>" width="100px">
							</div>
							<h6 style="font-family: sans-serif;" class="text-secondary mt-2"><b><?=$row['issue_name']?></b></h6>
							<p><b>Location: </b><?=$row['location']?></p>
							<p><?=$row['city_name']?>, <?=$row['state_name']?></p>
							<a href="<?=baseurl()?>/issue.php?id=<?=$row['issue_id']?>" class="btn theme-bg-r text-white">Send help</a>
						</div>
					</div>
				<?php		
			}
		?>
	</div>
	<div class="col-12 text-center pl-5 pr-5">
		<a href="<?=baseurl()?>/list-issues.php" class="btn theme-text-y shadow-md pl-5 pr-5 border rounded"><b>See more</b></a>
	</div>
</div>
<div class="row extra-light-bg p-5">
	<h1 class="col-12 text-center text-secondary">Heroes who took challenge</h1>
	<p class="col-12 text-center text-secondary">Real heroes don't fear challenges, they are helping every second!</p>
	<?php
  		$sql = "SELECT u.user_name, u.user_img, r.review, r.review_date, i.issue_name FROM users u INNER JOIN review r ON r.user_id = u.user_id INNER JOIN issues i ON i.issue_id = r.issue_id ORDER BY r.review_date DESC";
  		$result = $conn->query($sql);
  		if($result->num_rows > 0)
  		{
  			while($row = $result->fetch_assoc())
  			{
  				?>
  				<!-- person comment starts -->
		  		<div class="col-md-11 row col-sm-12 p-2 bg-white rounded mt-3">
					<div class="col-md-1">
						<img src="<?=baseurl()?>/assets/img/users/<?=$row['user_img']?>" class="rounded-circle" width="100px" height="100px">
					</div>
					<div class="col-md-10 pl-5">
						<b class="text-secondary"><?=$row['user_name']?></b>
						<p>
							<?=$row['review']?>
						</p>
						<b class="text-secondary">Issue: </b><a href="#">We need masks in our area</a>
					</div>
				</div>
		  		<!-- person comment ends -->
  				<?php
  			}
  		}
		?>
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
</script>
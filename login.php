<?php
	if(isset($_REQUEST['status']))
	{
		if($_REQUEST['status'] == 'fail')
		{
			?>
			<script>
				alert("Invalid email or password, try again");
			</script>
			<?php
		}
		if($_REQUEST['status'] == 'success')
		{
			?>
			<script>
				alert("Account created, login to continue");
			</script>
			<?php
		}
	}
	include("includes/utility.php");
	include("includes/headers.php");
	include("includes/navbar.php");
?>
	<div class="row p-5 theme-bg-y">
		<h4 class="col-12 mt-3 text-center">Login now</h4>
		<div class="col-sm-4 mt-2 bg-white shadow-md rounded offset-md-4 pt-4">
			<form class="p-5" method="POST" action="<?=baseurl()?>/includes/login_db.php">
				<div class="form-group">
				    <input type="text" name="email" class="form-control" placeholder="Please enter email">
			  	</div>
			  	<div class="form-group">
				    <input type="password" name="password" class="form-control" placeholder="Please enter password" required>
			  	</div>
			  	<div class="mb-3 text-center">
				  <small>Not on ChallengeVid? <a href="<?=baseurl()?>/sign-up.php">Join now</a></small>
				</div>
				<div class="form-group text-center">
				  <input type="submit" class="btn btn-primary" name="submit" value="Login now"/>
				</div>
			</form>
		</div>
	</div>

<?php
	include("includes/footer.php");
?>
<?php
	if(isset($_REQUEST['s']))
	{
		if($_REQUEST['s'] == 'fail')
		{
			?>
			<script>
				alert("Failed creating account, try again later");
			</script>
			<?php
		}
	}
	include("includes/utility.php");
	include("includes/headers.php");
	include("includes/navbar.php");
?>
<div class="row p-5 theme-bg-y" style="background-image: url('<?=baseurl()?>/assets/img/logo.png')!important; background-size: 10%; background-repeat: no-repeat; background-position: 10% 50% ;">
	<h4 class="col-12 mt-3 text-center">Create new account</h4>
	<div class="col-sm-4 mt-2 bg-white shadow-md rounded offset-md-4 pt-4">
		<form class="p-5" method="POST" action="<?=baseurl()?>/includes/sign_up_db.php">
			<div class="form-group">
				<input type="text" name="name" class="form-control" placeholder="Name" required>
			</div>
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="Email" required>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Password" required>
			</div>
			<div class="mb-3 text-center">
				<small>Already on ChallengeVid? <a href="<?=baseurl()?>/login.php">Login now</a></small>
			</div>
			<div class="form-group text-center">
				<input type="submit" class="btn btn-primary" name="submit" value="Create account"/>
			</div>
		</form>
	</div>
</div>
<?php
	include("includes/footer.php");
?>
<?php
	include("includes/utility.php");
	include("includes/headers.php");
	include("includes/navbar.php");
	include("includes/db_connection.php");
?>
<div class="row p-5 theme-bg-y">
	<h4 class="col-12 mt-3 text-center">Add details to better describe the issue</h4>
	<div class="col-sm-4 mt-2 bg-white shadow-md rounded offset-md-4 pt-4">
		<form class="p-5" method="POST" action="<?=baseurl()?>/includes/add_detail_db.php">
			<div class="form-group">
				<input type="text" name="description" class="form-control" placeholder="Details of the issue" required>
			</div>
			<div class="form-group">
				<input type="file" name="img" class="form-control" required>
			</div>
			<small>Don't feel like adding details? <a href="<?=baseurl()?>/issue.php?id=<?=$_REQUEST['id']?>">Click here</a></small>
			<div class="form-group mt-2 text-center">
				<input type="submit" class="btn btn-primary" name="submit" value="Create account"/>
			</div>
		</form>
	</div>
</div>
<?php
	include("includes/footer.php");
?>
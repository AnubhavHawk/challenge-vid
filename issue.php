<?php
	include("includes/utility.php");
	include("includes/headers.php");
	include("includes/navbar.php");
	include("includes/db_connection.php");
?>
<div class="row theme-bg-r p-5">
	<?php
		$sql = "SELECT * FROM issues WHERE issue_id = ".$_REQUEST['id'];
		$helped = 0;
		if(isset($_SESSION['user_id']))
		{
			$sql = "SELECT i.issue_name, i.location, c.city_name, s.state_name FROM issues i INNER JOIN city c ON i.city_id = c.city_id INNER JOIN state s ON i.state_id = s.state_id WHERE i.issue_id = ".$_REQUEST['id'];
			$result = $conn->query($sql);
			$helped_sql = "SELECT * FROM helped WHERE issue_id = ".$_REQUEST['id']." AND user_id = ".$_SESSION['user_id'];
			$helped_result = $conn->query($helped_sql);
			if($helped_result->num_rows > 0)
			{
				global $helped;
				$helped = 1;
			}
			$row  = $result->fetch_assoc();
		}
		else
		{
			$sql = "SELECT i.issue_name, i.location, c.city_name, s.state_name FROM issues i INNER JOIN city c ON i.city_id = c.city_id INNER JOIN state s ON i.state_id = s.state_id WHERE i.issue_id = ".$_REQUEST['id'];
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
		}
	?>
	<div class="col-12">
		<h2><?=$row['issue_name']?></h2>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p>
		<hr>
		<p><img src="<?=baseurl()?>/assets/img/marker.png" width="20px"><?=$row['location']?></p>
		<p><b><?=$row['city_name']?></b>, <?=$row['state_name']?></p>
	</div>
	<div class="col-12 mt-4">
		<h6 class="text-secondary">Descriptive images</h6>
		<?php
			$img_sql = "SELECT img_name FROM issue_img WHERE issue_id = ".$_REQUEST['id'];
			$img_result = $conn->query($img_sql);
			while($img_row = $img_result->fetch_assoc())
			{
				?>
				<a href="<?=baseurl()?>/assets/img/issues/<?=$img_row['img_name']?>" target="_blank"><img src="<?=baseurl()?>/assets/img/issues/<?=$img_row['img_name']?>" width="100px" height="100px"></a>
				<?php
			}
		?>
	</div>
</div>
<div class="row">
	<div class="col-12 extra-light-bg pl-5 pr-5 pt-2 pb-1 text-center">
		<h1 style="display: inline-block;">18 </h1>&nbsp;<p style="display: inline-block;">People have upvoted as a  severe issue</p>
	</div>
	<?php
		if($helped == 0)
		{
			?>
			<!-- happy section -->
			<div class="col-12 p-5" style="background-image: url('<?=baseurl()?>/assets/img/sad.png'); background-size: 100px; background-position: 90% 50%; background-repeat: no-repeat;">
				<h2 class="theme-text-r col-9">You haven't helped them, take the challenge and help people resolve the issue !</h2>
			</div>
			<?php
		}
		else
		{
			?>
			<!-- sad section -->
			<div class="col-12 p-5" style="background-image: url('<?=baseurl()?>/assets/img/smile.png'); background-size: 100px; background-position: 90% 45%; background-repeat: no-repeat;">
				<h2 class="theme-text-y col-9">We are happy to know that you have helped them !</h2>
				<p class="col-9">Challenge your friends now. <a href="#">click here</a></p>
			</div>
			<?php
		}
	?>
	
	<div class="col-12 extra-light-bg p-5">
		<h3 class="text-secondary text-center">Reviews</h3>
		<?php
		$r_sql = "SELECT u.user_name, u.user_img, r.review, r.review_date FROM users u INNER JOIN review r ON r.user_id = u.user_id INNER JOIN issues i ON i.issue_id = r.issue_id WHERE i.issue_id = ".$_REQUEST['id']." ORDER BY r.review_date DESC";
		?>
		<p class="text-secondary text-center">Know what others find about this issue</p>
		<div class="row">
			<?php
				$review_result = $conn->query($r_sql);
				if($review_result->num_rows > 0)
				{
					while($review_row = $review_result->fetch_assoc())
					{
						$date= date_create($review_row['review_date']);
						?>
							<!-- review start -->
							<div class="col-md-6 col-sm-12">
								<p class="bg-white p-2 text-secondary rounded">
									<b><?=$review_row['user_name']?></b> <i>(<?=date_format($date,"d M y - h:i a")?>)</i> <br/>
									<?=$review_row['review']?>
								</p>
							</div>
							<!-- review end -->
						<?php	
					}
				}
				else
				{
					?>
					<div class="col-12 text-center">No reviews found</div>
					<?php
				}
				
			?>
		</div>
		<form class="mt-2" action="<?=baseurl()?>/includes/add_comment_db.php" method="POST">
			<fieldset  <?php if(!isset($_SESSION['user_id'])){echo "disabled";}?> >
			<h6 class="theme-text-r">Add a review</h6>
			<textarea class="form-control mt-2" rows="3" name="description"  <?php if(!isset($_SESSION['user_id'])){echo "disabled placeholder='please login to add review'";} else{echo "placeholder='Enter your review'"; } ?>></textarea>
			<input type="hidden" name="issue_id" value="<?=$_REQUEST['id']?>">
			<input type="submit" name="submit" value="Add review" class="btn mt-2 text-white theme-bg-r">
			</fieldset>
		</form>
	</div>
	<!-- share buttons -->
	<div class="col-12 fixed-bottom">
		<hr>
		<div class="row p-2">
			<div class="col-4">
				<a href="#" class="btn btn-block btn-warning">Pay via UPI-1</a>
			</div>
			<div class="col-4">
				<!-- <a href="#" class="btn btn-block btn-warning">Share</a> -->
				<a class="btn btn-block btn-warning" href="whatsapp://send?text=" id="share-link" data-action="share/whatsapp/share">Share</a>
			</div>
			<div class="col-4">
				<a href="#" class="btn btn-block btn-warning">Pay via UPI-2</a>
			</div>
		</div>
	</div>
</div>
<?php
	include("includes/footer.php");
?>
<div class="bg-white" style="height: 12vh;">
	
</div>
<script>
	$('#share-link').click(function(e){
		e.preventDefault();
		window.location = "whatsapp://send?text="+document.URL;
	})
</script>
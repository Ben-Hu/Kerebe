<?php
	session_start(); // Start the user session
	include "database.php"; 
	include "head.php"; // Stylesheets and scripts
	include "top_navi.php"; // Top navigation bar
	
	include_once "listingdatabase.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <title><?php echo "$info[1]"; ?></title>

</head>

<body>
	<!-- Sidebar -->
	<div id="sidebar-wrapper">
		<ul class="sidebar-nav">
			<?php
				while ($tenant = pg_fetch_row($allTenants)) {
					echo "<li><a href='profile.php?user=$tenant[0]'>$tenant[0]</a></li>";
				}
			?>
		</ul>
	</div>
	
	<!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-md-9">
			
				<!-- Form is activated when user edits his/her listing. -->
				<form method="post">
					<div class="thumbnail">
						<img class="img-responsive" src="http://placehold.it/800x300" alt="">
						<div class="caption-full">

							<!-- Rating -->
							<h4 class="pull-right" id="rating"><?php echo "$info[3]"; ?></h4>

							<!-- Address -->
							<h4 class="edit" name="address"><?php echo "$info[1]"; ?> </h4>
						</div>
						
						<div class="ratings">
							<p class="pull-right">
								<button class="btn btn-default likedislike" id="1">
									<span class="glyphicon glyphicon-thumbs-up"></span>
								</button>
								<button class="btn btn-default likedislike" id="0">
									<span class="glyphicon glyphicon-thumbs-down"></span>
								</button>
							</p>
						
							<!-- City -->
							<p class="edit" name="city"><?php echo "$info[2]"; ?></p>
						</div>
					</div> <!-- /.thumbnail -->
					
					<div class="well">
						<div class="pull-right">
							<?php
								if ($isOwner != 0) { 
									echo "<a class='btn btn-success' id='edit-listing'>Edit</a>
											<a class='btn btn-danger' id='delete'>Delete</a>"; 
								} 
							?>
						</div>
						
						<!-- Description -->
                        <p class="edit" name="description"><?php echo "$info[4]"; ?></p>
						
					</div>
				
					<!-- Skills/Interest tags -->
					<footer>
						<div class="row">
							<div class="col-lg-12">
								<?php
									$allTags = "";
									while ($tag = pg_fetch_row($tags)) {
										$allTags = $allTags . "," . $tag[0]; 
										echo "
											<button class='btn btn-info btn-xs tag' disabled>$tag[0]</button>
										";
									}
									$newAllTags = ltrim($allTags, ',');
								?>
								<input id="interests" type="hidden" class="form-control" value="<?php echo "$newAllTags"; ?>" name="interests" hidden="true" required>
							</div>
						</div>
					</footer>
				</form>	
			</div> <!-- /.col-md-9 -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->

	<script>
		var user = <?php echo json_encode($user); ?>;
		var lid = <?php echo "$id"; ?>;
		var ifLiked = <?php echo "$liked"; ?>;
		var likedVal = <?php echo json_encode($likedResult[0]); ?>;
	</script>
	<script src="js/listing.js"></script>
</body>
</html>
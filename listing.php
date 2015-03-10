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
									<span class="glyphicon glyphicon-plus"></span>
								</button>
								<button class="btn btn-default likedislike" id="0">
									<span class="glyphicon glyphicon-minus"></span>
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
				</form>
				
			</div> <!-- /.col-md-9 -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->

	<script async>
		var user = <?php echo json_encode("$user"); ?>;
		var ifLiked = <?php echo "$liked"; ?>;
		if (ifLiked != 0) { // if the user has rated this listing
			// Get the value of their rating.
			var likedVal = <?php echo json_encode("$likedResult[0]"); ?>;
			toggleRating(likedVal);
		} 
				
		$(".likedislike").click(function(e) {
			e.preventDefault();
			var lid = '<?php echo "$id"; ?>';
			var theRating = $(this).attr("id");
			var other = 1 - theRating;
 			toggleRating(theRating);
			
			// Get the currentClass after toggling the rating button
			var currentClass = $(this).attr("class");
			
			// If the button was disabled
			if (currentClass == "btn btn-default likedislike") { 
				var theAction = "D"; // delete rating
			} else { // Something was rated
				var theAction = "A"; // add rating
			}
			changeRating(theRating, theAction);
			var funct = "rate";
			$.ajax({
				url: "listingfunctions.php",
				type: "POST",
				data: { functt : funct, username : user, rating : theRating, listid : lid, action : theAction }
			});
			
		});
	</script>

	<script>
		$("#edit-listing").click(function() {
			$(".edit").each(function(i) {
				// Replace the listing information fields with input fields
				// for users to modify if needed.
				$(this).replaceWith("<input class='form-control' type='text' name='" + 
									$(this).attr("name")  + 
									"' value='" + $(this).text() + "' />");
			});
			// Replace the "Edit" button with a "Save" button to save any changes
			// made when editing a listing.
			$(this).replaceWith("<button type='submit' class='btn btn-success' name='save' id='save'>Save</button>");
	
			// Replace the delete button with a "Cancel" button to cancel editing.
			$("#delete").replaceWith("<a class='btn btn-danger' id='cancel'>Cancel</a>");
		});

		// Remove the input fields by reloading the page.
		$("#cancel").click(function() {
			location.reload();
		});
	</script>

	<script>
	$("#delete").click(function() {
		var confirmBox = confirm("Are you sure you want to delete this space?");
		if (confirmBox == true) { // The user confirmed.
			var lid = '<?php echo "$id"; ?>';
			var funct = "delete";	
			$.ajax({
				url: "listingfunctions.php",
				type: "POST",
				data: { f : funct, listid : lid }
			});
			// Redirect to the index page on deletion.
			window.location = "http://ec2-52-11-184-213.us-west-2.compute.amazonaws.com";
		}
	}); 
	</script>	
</body>
</html>
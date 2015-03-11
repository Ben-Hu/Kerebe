<?php
	session_start();

	// If the "post a new listing" form is submitted
	if (isset($_POST['post'])) {
		$user = $_SESSION['username'];
		
		// Get the information entered in the form.
		$addr = $_POST['address'];
		$city = $_POST['city'];
		$description = $_POST['description'];
		$insertListing = "INSERT INTO listings (address, city, description) VALUES ('$addr', '$city', '$description')";
		
		querydb($insertListing);
		
		// Get the id of the new listing.
		$retrieveID = "SELECT listid FROM listings WHERE address='$addr' AND city='$city'";
		$getid = querydb($retrieveID);
		$id = pg_fetch_row($getid);

		// Insert the owner into posted and add the owner as a tenant.
		querydb("INSERT INTO posted VALUES ($id[0], '$user')");
		querydb("INSERT INTO tenant VALUES ($id[0], '$user')");
		header("Location: http://ec2-52-11-184-213.us-west-2.compute.amazonaws.com/listing.php?id=$id[0]"); 
	}
?>

<div id="sidebar-wrapper">
	<ul class="sidebar-nav">
		<?php
			// If the user is logged in
			if (isset($_SESSION['username'])) {
				$getListing = "SELECT p.listid, address FROM posted p JOIN listings l ON p.listid = l.listid WHERE username='$user'"; 
				$result = querydb($getListing);
				// Display the listing owned by the logged in user.
				while ($row = pg_fetch_row($result)) {
					echo "<li><a href='listing.php?id=$row[0]'>$row[1]</a></li>";
				}
					echo "
						<li>
							<a href='#' onclick='toggleVisibility()'>Post</a>
							<div id='listing-form' style='display:none'>
								<form method='post'>
									<div>
										<input type='text' class='form-control' name='address' placeholder='Address'>
									<br />
										<input type='text' class='form-control' name='city' placeholder='City'>
									<br />
										<input type='text' class='form-control' name='description' placeholder='Description'>
									<br />
										<button type='submit' class='btn btn-default' name='post'>Post</button>
									</div>
								</form>
							</div> 
						</li>
					";
			} else { // The user has not logged in so display the "Login/Register" button.
				echo "<li><a href='#' data-toggle='modal' data-target='#login'>Login/Register</a></li>";
			}
		?>
	</ul>
</div>

<!-- Toggle the visibility of the form to post listings. -->
<script>
	function toggleVisibility() {
		$("#listing-form").toggle();
	}
</script>
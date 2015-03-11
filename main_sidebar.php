<?php 
	session_start();
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
								<form method='post' action='postdatabase.php'>
									<div>
										<input type='text' class='form-control' maxlength='25' name='address' placeholder='Address' required>
									<br />
										<input type='text' class='form-control' maxlength='25' name='city' placeholder='City' required>
									<br />
										<input type='text' class='form-control' maxlength='10240' name='description' placeholder='Description' required>
									<br />
										<input type='text' class='form-control' data-role='tagsinput' name='interests' placeholder='Comma-separated interests' required> 
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
<script async>
	function toggleVisibility() {
		$("#listing-form").toggle();
	}
</script>
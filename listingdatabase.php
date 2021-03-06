<?php

	/* Retrieve information for the listing. */
	
	$user = $_SESSION["username"]; // Check if a user is logged in

	// Get the information from the database for the current listing
	$id = $_GET['id'];
	$getInfo = querydb("SELECT * from listings WHERE listid = $id");
	$info = pg_fetch_row($getInfo);
	
	// Get skills/interest tags for the current listing
	$tags = querydb("SELECT interest FROM listinterests WHERE listid = $id");

	// Get the tenants for the current database
	$allTenants = querydb("SELECT username FROM tenant WHERE listid = $id");

	// Check if current page was rated by the current user
	$ifRated = querydb("SELECT liked FROM postrated WHERE username = '$user' AND listid = $id");
	$likedResult = pg_fetch_row($ifRated);
	$liked = pg_num_rows($ifRated);

	// Check if user owns this page
	$owner = querydb("SELECT * from posted WHERE username = '$user' AND listid = $id");
	$isOwner = pg_num_rows($owner);
	
	// Update the listing information in the database if it was modified.
	if (isset($_POST['save'])) {
		$addr = $_POST['address'];
		$city = $_POST['city'];
		$desc = $_POST['description'];
		$interestString = $_POST['interests'];
		// Get the array of interests
		$interests = explode(",", $interestString);
			
		querydb("UPDATE listings SET address = '$addr', city = '$city', description = '$desc' WHERE listid = $id");
		querydb("DELETE FROM listings WHERE listid = $id");
		
		// Update the list of interests
		querydb("DELETE FROM listinterests WHERE listid = $id");
		foreach ($interests as &$interest) {
			querydb("INSERT INTO listinterests VALUES($id, '$interest')");
		}
		$tags = querydb("SELECT interest FROM listinterests WHERE listid = $id");
		
		// Query the database again to get the updated listing information
		$getInfo = querydb("SELECT * from listings WHERE listid = $id");
		$info = pg_fetch_row($getInfo);
	}
?>
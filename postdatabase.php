<?php
	session_start();
	include "database.php";

	// If the "post a new listing" form is submitted
	$user = $_SESSION['username'];

	// Get the information entered in the form.
	$addr = $_POST['address'];
	$city = $_POST['city'];
	$description = $_POST['description'];
		
	$interestString = $_POST['interests'];
	// Get the array of interests
	$interests = explode(",", $interestString);
		
	$insertListing = "INSERT INTO listings (address, city, description) VALUES ('$addr', '$city', '$description')";
	
	querydb($insertListing);
		
	// Get the id of the new listing.
	$retrieveID = "SELECT listid FROM listings ORDER BY listid DESC LIMIT 1";
	$getid = querydb($retrieveID);
	$id = pg_fetch_row($getid);

	// Insert the owner into posted and add the owner as a tenant.
	querydb("INSERT INTO posted VALUES ($id[0], '$user')");
	querydb("INSERT INTO tenant VALUES ($id[0], '$user')");
		
	// Insert the interests
	foreach ($interests as &$interest) {
		querydb("INSERT INTO listinterests VALUES($id[0], '$interest')");
	}
	header("Location: http://ec2-52-11-184-213.us-west-2.compute.amazonaws.com/listing.php?id=$id[0]");
?>